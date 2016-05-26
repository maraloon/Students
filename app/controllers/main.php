<?php
//Соединяемся с базой
$db=new DataBase($config['db']);

//Соединяемся с таблицей
$table=new StudentDataGateway($db->connection());
//возвращает массив, где каждый students[] - объект Student
$students=$table->getStudents();
