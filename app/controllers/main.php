<?php
//Соединяемся с базой
$db=new DataBase($config['db']);

//Соединяемся с таблицей
$table=new StudentDataGateway($db->connection());

//Параметры для постраничной навигации
$limit=10; //студентов на странице
$studentsNum=$table->countStudents(); //всего студентов в базе
$pages=ceil($studentsNum/$limit); //всего страниц
$currentPage=isset($_GET['page']) ? $_GET['page'] : 1; //текущая страница
if($currentPage<=0){$currentPage=1;} //если хакир передаст строку, она преобразуется в int 1
$offset=($currentPage-1)*$limit; //сдвиг, иначе - с какой строки начать отображение


//возвращает массив нужных студентов
$students=$table->getStudents($limit,$offset);