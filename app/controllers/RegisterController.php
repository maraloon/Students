<?php
namespace Project\Controllers;
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
		setcookie('hash',$student->hash,time()+3600*12*365,'/',null,false,true);
		header('Location: register_ok');	
	}


}