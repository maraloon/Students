<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;
use \StudentList\Models\Student;
class ERController extends ViewController{
	protected $validModules=array('edit','edit_ok','register','register_ok');
	protected $keysOfViewVars=array('student','token','validErrors');
	
	protected $student;
	protected $token;
	protected $validErrors=array(); //все ошибки во время регистрации

	public function __construct($viewName,$c){
		parent::__construct($viewName,$c);
	}

	public function parseRequest(){
		parent::parseRequest();
	}

	protected function registerModule(){
		$this->mainCode();
		$this->viewName='pages/register';
	}
	protected function editModule(){
		$this->mainCode();
		$this->viewName='pages/edit';
	}

	protected function register_okModule(){
		$this->viewName='status/register_ok';
	}
	protected function edit_okModule(){
		$this->viewName='status/edit_ok';
	}

	protected function mainCode(){
		$this->setToken();

		$oldStudentData=$this->prepareStudentForForm();
		//Если данные формы передавались
		if(!empty($_POST)){
			
			//Проверка токена
			if(!$this->checkToken()){
				//Попытка взлома
				  //header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
				  header(' ', true, 400);
			}
			else{
				//Тестовый студент
				$newStudentData=new Student();

				$newStudentData=$this->fillStudent($newStudentData);

				//Ищем ошибки в заполнении
				$id=$oldStudentData->getId();
				$validErrors=$this->c['validator']->validate($newStudentData,$id);

				//нет ошибок
				if(empty($validErrors)){
					if ($this->module=='edit') {
						$this->editStudent($newStudentData);
					}
					elseif($this->module=='register'){
						$this->addStudent($newStudentData);
					}
				}
				//ошибки в форме
				else{
					$this->validErrors=$validErrors; //покажет ошибки
					$oldStudentData=$newStudentData; //покажет данные студента в форме
				}
			}
		}
		$this->student=$oldStudentData;
	}

	protected function setToken(){
		$this->token=(isset($_COOKIE['token'])) ? $_COOKIE['token'] : Util::randHash(20);
		setcookie('token',$this->token,time()+3600,'/',null,false,true);
	}

	protected function checkToken(){
		if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!=$_POST['token']) ){
			return false;
		}
		return true;
	}

	//Передаём весь POST, не фильтруя лишнее - это сделает класс
	protected function fillStudent(Student $student){
		$studentData=$this->filter($_POST);
		foreach ($studentData as $field) {
			$field=trim(strval($field));
		}

		$student->addInfo($studentData);

		if ($this->module=='edit') {
			$student->hash=$_COOKIE['hash'];
		}
		elseif($this->module=='register'){
			$student->hash=Util::randHash();
		}
		return $student;
	}

	//Какой текст показать в полях формы
	protected function prepareStudentForForm(){
		$student=new Student();
		if ($this->module=='edit') {
			$studentRow=$this->c['table']->getStudentByHash($_COOKIE['hash']);
			$student->addInfo($studentRow);
		}
		/*elseif($this->controller=='register'){
			//return new Student();
		}*/
		return $student;
	}

	//Фильтрует передаваеммые пользователем данные от нежелательных переменных
	protected function filter($post){
		$template=array_flip(array('name','sname','group_num','points','gender','email','b_year','is_resident','hash'));
		$infoArray=array_intersect_key($template,$post);
		return $post;
	}

	protected function addStudent(Student $student){
		$this->c['table']->addStudent($student);
		$this->c['auth']->logIn($student->hash);
		header('Location: main?register_ok');	
	}

	protected function editStudent(Student $student){
		$edit=$this->c['table']->editStudent($student);
		header('Location: main?edit_ok');
	}

}