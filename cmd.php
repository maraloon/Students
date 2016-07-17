#!/usr/bin/php
<?php
include ("../app/bootstrap.php");

function getStudents($db){
	/*
	* возвращает массив, где каждый studentsRows - объект Student
	* $limit записей, начиная с $offset
	*/

	//Формируем строку запроса
	$rows = $db->prepare("SELECT * FROM `students`");
	$rows->execute();
	
	$studentsRows=$rows->fetchAll(PDO::FETCH_ASSOC);
	//Подготавливаем массив
	$students=array();
	foreach($studentsRows as $studentRow){
		$student=new Student();
		$student->addInfo($studentRow);
		$students[]=$student;
	}
	return $students;
}

//-----------------//
$students=getStudents($container['db']);
//var_dump($students);


foreach ($students as $student) {
	$validator=new StudentValidator($student,$container,$student->getId());
	$validErrors=$validator->getErrors();

	//нет ошибок
	if(!empty($validErrors)){
		//echo "Ошибки заполнения. ID:".$student['id'];
		echo "ID:".$student->getId()." - INVALID\n";
		foreach ($validErrors as $error) {
			echo "	ERROR: ".$error."\n";
		}
		//var_dump($validErrors);	
	}
	else{
		echo "ID:".$student->getId()." - VALID\n";
	}
}
