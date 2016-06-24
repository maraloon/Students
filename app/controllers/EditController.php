<?php

class EditController extends ViewController{
	protected $student;
	protected $token;
	protected $userErrors=array(); //все ошибки во время регистрации

	public function __construct($c){

		if (isset($_COOKIE['hash'])) { //нет кука с хешем => не выполнять скрипт
		/*ОП, эту куку нужно как-то проверять?*/
			if ($c['router']->getModule()=='edit') { //если edit_ok, то скрипт не выполняется лишний раз
				//Токен
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
							$this->editStudent($editStudent,$c['table']);
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
					$this->student=$this->prepareStudentForForm($c['table']);
				}

			}
		}
		else{
			header(' ', true, 503);
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
	protected function fillStudent($student){
		foreach($student as $fieldName=>&$fieldValue){
			$fieldValue=isset($_POST[$fieldName]) ? trim(strval($_POST[$fieldName])) : '';
		}
		$student->hash=$_COOKIE['hash'];

		return $student;
	}

	protected function editStudent(Student $student,$table){
		$table->editStudent($student);
		if( empty($table->userErrors) ){
			//Успешное изменение данных
			header('Location: edit_ok');	
		}
		//ошибки при добавлениии информации в таблицу
		else{
			foreach($table->userErrors as $error){
				$this->userErrors[]=$error;
			}

		}
	}


	protected function prepareStudentForForm($table){
		$studentRow=$table->getStudentByHash($_COOKIE['hash']);

		//Создаём объект студента
		$student=new Student();
		//безопасное получение переданных значений
		foreach($student as $fieldName=>&$fieldValue){
			$fieldValue=isset($studentRow[$fieldName]) ? trim(strval($studentRow[$fieldName])) : '';
		}
		return $student;
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