<?php
namespace StudentList\Controllers;
use \StudentList\Helpers;
class MainController extends ViewController{
	protected $validModules=array('main','search');
	protected $keysOfViewVars=array('students','viewer','isAuthorized','user','find','pages','currentPage','register_ok','edit_ok');

	function __construct($viewName,$c){
		parent::__construct($viewName,$c);
	}

	public function parseRequest(){
		parent::parseRequest();
	}

	protected function mainModule(){
		$this->mainCode();
		$this->viewName='pages/main';
	}
	protected function searchModule(){
		$this->mainCode();
		$this->viewName='pages/search';
	}

	protected function mainCode(){
	//Авторизован ли пользователь
		$isAuthorized=$this->c['auth']->checkAuth();
	//Получаем данные юзера
		$user=$isAuthorized ? $this->c['auth']->getUser() : NULL;

	//Параметры для поиска
		$find=isset($_GET['find']) ? strval($_GET['find']) : NULL;

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
				$sortBy=strval($_GET['sortBy']);
			}	
		}
		if (isset($_GET['orderBy'])) {
			if (in_array($_GET['orderBy'], array('asc','desc'))){
				$orderBy=strval($_GET['orderBy']);
			}
		}

	//Статус изменения данных
		$register_ok=isset($_GET['register_ok']) ? strval($_GET['register_ok']) : NULL;
		$edit_ok=isset($_GET['edit_ok']) ? strval($_GET['edit_ok']) : NULL;



		$table=$this->c['table'];
		$students=$table->getStudents($sortBy,$orderBy,$limit,$offset,$find);
		//Генерация динамического контента для представления
		$viewer = new Helpers\TableUrlMaker($currentPage,$sortBy,$orderBy,$find,$this->c['router']);

		//Из локальных в глобальные, чтобы передать в packViewVars()
		foreach ($this->keysOfViewVars as $key) {
			$this->$key=$$key;
		}
	}

}