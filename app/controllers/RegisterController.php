<?php

class RegisterController extends ViewController{
	protected $validModules=array('register','register_ok');
	protected $student;
	protected $token;
	protected $userErrors=array(); //все ошибки во время регистрации

	public function __construct($c){

		if (in_array($c['router']->getModule(), $this->validModules)) {

			$module=$c['router']->getModule().'Module';
			var_dump($module);
			$this->$module($c);
		}
	}


	protected function registerModule($c){
		$this->setToken();
		//Если данные формы передавались
		if(!empty($_POST)){
			
			//Проверка токена
			if(!$this->checkToken()){
				//Попытка взлома
				  //header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
				  header(' ', true, 400); //Так, вроде правильней
			}
			else{
				//Тестовый студент
				$editStudent=new Student();

				$editStudent=$this->fillStudent($editStudent);						

				
				//Ищем ошибки в заполнении
				$valid=new StudentValidator($editStudent);
				
				//нет ошибок
				if(empty($valid->errors)){	
					$this->addStudent($editStudent,$c['table']);	
				}
				//ошибки в форме
				else{		
					foreach($valid->errors as $error){
						$this->userErrors[]=$error;
					}
				}
				
				if(!empty($this->userErrors)){
					//заполняет форму регистрации значениями пользователя
					$this->student=$editStudent;
				}

			
			}

		}
		//Если юзер перешел на форму и еще ничего не передавал
		else{
			
			//заполняет форму регистрации пустыми значениями
			$this->student=new Student();

			
		}
	}


	protected function register_okModule($c){}

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
		$student->hash=Util::randHash(20);

		return $student;
	}


	protected function addStudent(Student $student,$table){
		$table->addStudent($student);

		if( empty($table->userErrors) ){
			//Передаём кук с хешем
			setcookie('hash',$student->hash,time()+3600*12*365,'/',null,false,true);
			//Переправить
			header('Location: register_ok');	
		}
		//ошибки при добавлениии информации в таблицу
		else{
			foreach($table->userErrors as $error){
				$this->userErrors[]=$error;
			}

		}
	}


	public function showView($viewName,$viewData=NULL){
		/*$viewData['authorized']=$this->isAuthorized;
		if ($this->isAuthorized) {
			$viewData['user']=$this->user;
		}*/
		$viewData['student']=$this->student;
		$viewData['token']=$this->token;
		$viewData['userErrors']=$this->userErrors;

		parent::showView($viewName,$viewData);
	}

}