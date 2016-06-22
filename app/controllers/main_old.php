<?php
//Соединяемся с базой
$db=new DataBase($config['db']);

//Соединяемся с таблицей
$table=new StudentDataGateway($db->connection());


//Параметры для поиска
$find=isset($_GET['find']) ? $_GET['find'] : NULL;


//Параметры для постраничной навигации
$limit=10; //студентов на странице
$studentsNum=$table->countStudents($find); //всего студентов в базе
$pages=ceil($studentsNum/$limit); //всего страниц
$currentPage=isset($_GET['page']) ? $_GET['page'] : 1; //текущая страница
if($currentPage<=0){$currentPage=1;} //если хакир передаст строку, она преобразуется в int 1
$offset=($currentPage-1)*$limit; //сдвиг, иначе - с какой строки начать отображение


//Параметры для сортировки
$sortBy='points';
$orderBy='asc';

if (isset($_GET['sortBy'])) {
	if (in_array($_GET['sortBy'], array('name','sname','group_num','points'))){
		$sortBy=$_GET['sortBy'];
	}	
}
if (isset($_GET['orderBy'])) {
	if (in_array($_GET['orderBy'], array('asc','desc'))){
		$orderBy=$_GET['orderBy'];
	}
}




//возвращает массив нужных студентов
$students=$table->getStudents($sortBy,$orderBy,$limit,$offset,$find);

//Генерация динамического контента для представления
$viewer = new ViewHelper($currentPage,$sortBy,$orderBy,$find);