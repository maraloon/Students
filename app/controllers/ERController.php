<?php

class ERController extends ViewController{
	protected $validModules=array('edit','edit_ok','register','register_ok');
	protected $controller;
	protected $student;
	protected $token;
	protected $validErrors=array(); //все ошибки во время регистрации

	public function __construct($viewName,$c){
		parent::__construct($viewName,$c);
	}

	public function parseRequest(){
		if (in_array($this->c['router']->getModule(), $this->validModules)) {

			$this->controller=$this->c['router']->getModule();
			$module=$this->controller.'Module';
			$this->$module();

			#Сделать как в MainController без $this
			foreach (array('student','token','validErrors') as $value) {
				$this->viewData[$value]=$this->$value;
			}

			parent::showView();
		}

	}


	protected function registerModule(){
		$this->Module();
	}
	protected function editModule(){
		$this->Module();
	}

	protected function register_okModule(){}
	protected function edit_okModule(){}

	protected function Module(){

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
					if ($this->controller=='edit') {
						$this->editStudent($newStudentData);
					}
					elseif($this->controller=='register'){
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
			$post=trim(strval($field));
		}

		$student->addInfo($studentData);

		if ($this->controller=='edit') {
			$student->hash=$_COOKIE['hash'];
		}
		elseif($this->controller=='register'){
			$student->hash=Util::randHash();
		}
		return $student;
	}

	//Какой текст показать в полях формы
	protected function prepareStudentForForm(){
		$student=new Student();
		if ($this->controller=='edit') {
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
		$c['auth']->authorize($student->hash);
		header('Location: register_ok');	
	}

	protected function editStudent(Student $student){
		$edit=$this->c['table']->editStudent($student);
		header('Location: edit_ok');
	}

}