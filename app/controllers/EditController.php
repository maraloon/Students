<?php

class EditController extends ERController{
	protected $validModules=array('edit','edit_ok');

	protected function editModule(){
		if (isset($_COOKIE['hash'])) {
			parent::Module();
		}
		else{
			header(' ', true, 503);
		}

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
		foreach($student as $fieldName=>&$fieldValue){
			$fieldValue=isset($studentRow[$fieldName]) ? trim(strval($studentRow[$fieldName])) : '';
		}
		return $student;
	}

	protected function fillStudent(Student $student){
		parent::fillStudent($student);
		$student->hash=$_COOKIE['hash'];
		return $student;
	}

	protected function editStudent(Student $student){
		$this->c['table']->editStudent($student);

		if( empty($this->c['table']->userErrors) ){
			//Успешное изменение данных
			header('Location: edit_ok');	
		}
		//ошибки при добавлениии информации в таблицу
		else{
			foreach($this->c['table']->userErrors as $error){
				$this->userErrors[]=$error;
			}

		}
	}
}