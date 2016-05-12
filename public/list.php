<?php
//Соединяемся с базой
$table=new StudentDataGateway($config->db); //может быть это нужно в bootstrap?

//возвращает массив, где каждый students[] - объект Student
$students=$table->getStudents();