<?php
//Соединяемся с базой, берём все нужные значения
$table=new StudentDataGateway($config->db); //возможно, это в bootstrap

//возвращает массив, где каждый student - объект Student
$student=$table->getStudents();


//Передаем значения представлению
include("views/list.php");