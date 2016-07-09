<?php
namespace Project\Controllers;
class EditController extends ERController{
	protected $validModules=array('edit','edit_ok');

	protected function editModule(){
		parent::Module();
	}

	protected function edit_okModule(){}

	protected function writeStudentToDB(Student $student){
		$this->editStudent($student);
	}

	protected function prepareStudentForForm(){
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

	protected function fillStudent(Student $student){
		parent::fillStudent($student);
		$student->hash=$_COOKIE['hash'];
		return $student;
	}

	protected function editStudent(Student $student){
		$edit=$this->c['table']->editStudent($student);
		header('Location: edit_ok');
	}
}