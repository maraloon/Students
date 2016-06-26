<?php

abstract class ERController extends ViewController{
	protected $validModules=array();
	protected $student;
	protected $token;
	protected $userErrors=array(); //все ошибки во время регистрации

	public function __construct($container){
		parent::__construct($container);

		if (in_array($this->c['router']->getModule(), $this->validModules)) {

			$module=$this->c['router']->getModule().'Module';
			$this->$module($this->c);
		}
	}

	protected function Module(){

		$this->setToken();
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

				$student=static::fillStudent($student);

				//Ищем ошибки в заполнении
				$valid=new StudentValidator($student);
				
				//нет ошибок
				if(empty($valid->errors)){	
					//$this->addStudent($student);
					static::writeStudentToDB($student);	
				}
				//ошибки в форме
				else{		
					foreach($valid->errors as $error){
						$this->userErrors[]=$error;
					}
				}
				
				if(!empty($this->userErrors)){
					$this->student=$student;
				}
			}

		}
		//Если юзер перешел на форму и еще ничего не передавал
		else{
			$this->student=static::prepareStudentForForm();
			
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
		foreach($student as $fieldName=>&$fieldValue){
			$fieldValue=isset($_POST[$fieldName]) ? trim(strval($_POST[$fieldName])) : '';
		}
		return $student;
	}

	/*
	* Переопределяется в дочернем классе
	* Запись или изменение пользователя в БД
	*/
	protected function writeStudentToDB(Student $student){}

	/*
	* Переопределяется в дочернем классе
	* Какой текст показать в полях формы
	*/
	protected function prepareStudentForForm(){}



	public function showView($viewName){
		$this->viewData['student']=$this->student;
		$this->viewData['token']=$this->token;
		$this->viewData['userErrors']=$this->userErrors;

		parent::showView($viewName);
	}

}