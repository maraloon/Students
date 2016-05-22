<?php
//Соединяемся с базой
/*$table=new StudentDataGateway($config['db']);

//возвращает массив, где каждый students[] - объект Student
$students=$table->getStudents();


$view='main';
*/


$db=new DataBase($config['db']);
$table=new StudentDataGateway($db->connection());
$students=$table->getStudents();
$view='main';
