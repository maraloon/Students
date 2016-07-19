<?php

class ERController extends ViewController{
	protected $validModules=array('edit','edit_ok','register','register_ok');
	protected $controller;
	protected $student;
	protected $token;
	protected $userErrors=array(); //все ошибки во время регистрации

	public function __construct($viewName,$c){
		parent::__construct($viewName,$c);
	}

	public function parseRequest(){
		if (in_array($this->c['router']->getModule(), $this->validModules)) {

			$this->controller=$this->c['router']->getModule();
			$module=$this->controller.'Module';
			$this->$module();
		}
		

		#Сделать как в MainController без $this
		foreach (array('student','token','userErrors') as $value) {
			$this->viewData[$value]=$this->$value;
		}

		parent::showView();
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

		$this->student=$this->prepareStudentForForm();
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
				$student=new Student();

				$student=$this->fillStudent($student);

				//Ищем ошибки в заполнении
				$id=$this->student->getId();
				/*$validator=new StudentValidator($student,$this->c['table'],$id);
				$validErrors=$validator->getErrors();*/
				$validErrors=new StudentValidator($student,$this->c['table'],$id);

				//нет ошибок
				if(empty($validErrors)){
					if ($this->controller=='edit') {
						$this->editStudent($student);
					}
					elseif($this->controller=='register'){
						$this->addStudent($student);
					}
				}
				//ошибки в форме
				else{
					$this->student=$student;
					$this->userErrors=$validErrors;	
				}
			}
		}
	}

	protected function setToken(){
		$this->token= (isset($_COOKIE['token'])) ? $_COOKIE['token'] : Util::randHash(20);
		setcookie('token',$this->token,time()+3600,'/',null,false,true);
	}

	protected function checkToken(){
		if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!=$_POST['token']) ){
			return false;
		}
		return true;
	}

	//Передаём весь POST, не фильтруя лишнее - это сделает класс
	//безопасное получение переданных значений
	protected function fillStudent(Student $student){
		foreach ($_POST as $post) {
			$post=trim(strval($post));
		}
		$student->addInfo($_POST);

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
		if ($this->controller=='edit') {
			$studentRow=$this->c['table']->getStudentByHash($_COOKIE['hash']);

			//Создаём объект студента
			$student=new Student();
			//безопасное получение переданных значений
			foreach($studentRow as $fieldValue){
				$fieldValue=trim(strval($fieldValue));
			}
			$student->addInfo($studentRow);

			return $student;
		}
		elseif($this->controller=='register'){
			return new Student();
		}
	}

	protected function addStudent(Student $student){
		$this->c['table']->addStudent($student);
		$c['auth']->setHash($student->hash);
		header('Location: register_ok');	
	}

	protected function editStudent(Student $student){
		$edit=$this->c['table']->editStudent($student);
		header('Location: edit_ok');
	}

}