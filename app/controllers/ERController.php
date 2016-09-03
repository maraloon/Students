<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;
use \StudentList\Models\Student;
class ERController extends ViewController{

	public function registerModule(){
		if ($this->c['auth']->checkAuth()==false) {
			return $this->prepareForView();
		}
		return 403;
	}

	public function editModule(){
		if ($this->c['auth']->checkAuth()==true) {
			return $this->prepareForView();
		}
		return 403;
	}

	protected function prepareForView(){
		$token=$this->setToken();
		$student=$this->prepareStudentForForm();

		//Если данные формы передавались
		if(!empty($_POST)){
			//Проверка токена
			if(!$this->checkToken()){
				return 400; //Попытка взлома
			}
			else{
				$student=$this->fillStudent($student);
				//Ищем ошибки в заполнении
				$validErrors=$this->c['validator']->validate($student);
				//Если нет ошибок
				if(empty($validErrors)){
					if ($this->c['module']=='edit') {
						$this->editStudent($student);
					}
					elseif($this->c['module']=='register'){
						$this->addStudent($student);
					}
				}
			}
		}
		//Переменные, используемые в представлении
		$router=$this->c['router'];
		$this->ViewVars = compact('student','token','validErrors','router');
	}

	protected function setToken(){
		$token=(isset($_COOKIE['token'])) ? $_COOKIE['token'] : Util::randHash(20);
		setcookie('token',$token,time()+3600,'/',null,false,true);
		return $token;
	}

	protected function checkToken(){
		if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!==$_POST['token']) ){
			return false;
		}
		return true;
	}

	//Какой текст показать в полях формы
	protected function prepareStudentForForm(){
		$student=new Student();
		if ($this->c['module']=='edit') {
			$student=$this->c['table']->getStudentByHash($_COOKIE['hash']);
			//$student->addInfo($studentRow);
		}
		/*elseif($this->c['module']=='register'){
			//return new Student();
		}*/
		return $student;
	}

	//Заполнить объект студента переданными данными
	protected function fillStudent(Student $student){
		$studentData=$this->filter($_POST);
		foreach ($studentData as $field) {
			$field=trim(strval($field));
		}

		$student->addInfo($studentData);

		if ($this->c['module']=='edit') {
			$student->hash=$_COOKIE['hash'];
		}
		elseif($this->c['module']=='register'){
			$student->hash=Util::randHash();
		}
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
		header('Location: main?registerOk');	
	}

	protected function editStudent(Student $student){
		$edit=$this->c['table']->editStudent($student);
		header('Location: main?editOk');
	}

}