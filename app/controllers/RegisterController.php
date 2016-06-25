<?php

class RegisterController extends ERController{
	protected $validModules=array('register','register_ok');


	protected function registerModule(){
		parent::Module();
	}

	protected function register_okModule(){}

	protected function writeStudentToDB(Student $student){
		$this->addStudent($student);
	}

	protected function prepareStudentForForm(){
		return new Student();
	}

	protected function fillStudent(Student $student){	
		parent::fillStudent($student);
		$student->hash=Util::randHash();
		return $student;
	}

	protected function addStudent(Student $student){
		$this->c['table']->addStudent($student);

		if( empty($this->c['table']->userErrors) ){
			//Передаём кук с хешем
			setcookie('hash',$student->hash,time()+3600*12*365,'/',null,false,true);
			//Переправить
			header('Location: register_ok');	
		}
		//ошибки при добавлениии информации в таблицу
		else{
			foreach($this->c['table']->userErrors as $error){
				$this->userErrors[]=$error;
			}

		}
	}


}