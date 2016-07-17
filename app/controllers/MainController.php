<?php

class MainController extends ViewController{

	function __construct($c){
		parent::__construct($c);
	}

	public function showView($viewName){
	//Авторизован ли пользователь
	$isAuthorized=$this->c['auth']->checkAuth();
	//Получаем данные юзера
	if ($isAuthorized) {
		$user=$this->c['auth']->getUser();
	}

	//Параметры для поиска
		$find=isset($_GET['find']) ? $_GET['find'] : NULL;

	//Параметры для постраничной навигации
		$limit=10; //студентов на странице
		$studentsNum=$this->c['table']->countStudents($find); //всего студентов в базе
		$pages=ceil($studentsNum/$limit); //всего страниц

		$currentPage=isset($_GET['page']) ? max($_GET['page'],1) : 1;
		$offset=($currentPage-1)*$limit;

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


		$table=$this->c['table'];
		$students=$table->getStudents($sortBy,$orderBy,$limit,$offset,$find);
		//Генерация динамического контента для представления
		$viewer = new ViewHelper($currentPage,$sortBy,$orderBy,$find,$this->c);
		


		//Данные, спользуемые в представлении
		foreach (array('students','viewer','isAuthorized','user','find','pages','currentPage') as $value) {
			$this->viewData[$value]=$$value;
		}

		parent::showView($viewName);
	}
}