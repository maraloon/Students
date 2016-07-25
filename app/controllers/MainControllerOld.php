<?php

class MainController extends ViewController{

	/*private $viewData=array(
		'students'=>'',
		'viewer'=>'',
		'authorized'=>'',
		'find'=>'',
		'pages'=>'',
		'currentPage'=>'',
		'title'
		);*/

	private $find; //строка поиска, если NULL, то поиск не используется
	private $currentPage; //текущая страница
	private $pages; //всего страниц
	private $offset; //смещение (с какого начинать показывать)
	private $limit=10; //строк на страницу
	private $sortBy; //по какому полю сортировка
	private $orderBy; //воскходящая/нисходящая сортировка

	private $isAuthorized; //статус авторизованности
	private $user; //данные авторизованного пользователя

	function __construct($c){
		parent::__construct($c);
		//Авторизован ли пользователь
		$this->isAuthorized=$this->c['auth']->checkAuth();
		//Получаем данные юзера
		if ($this->isAuthorized) {
			$this->user=$this->c['auth']->getUser();
		}
		//Устанавливаем переменные
		$this->setSearchVars();
		$this->setPageVars();
		$this->setSortVars();
	}

	private function setSearchVars(){
		$this->find=isset($_GET['find']) ? $_GET['find'] : NULL;
	}

	private function setPageVars(){
		//Параметры для постраничной навигации
		$limit=$this->limit; //студентов на странице
		$studentsNum=$this->c['table']->countStudents($this->find); //всего студентов в базе
		$pages=ceil($studentsNum/$limit); //всего страниц

		$currentPage=isset($_GET['page']) ? max($_GET['page'],1) : 1;
		$offset=($currentPage-1)*$limit; //сдвиг, иначе - с какой строки начать отображение

		$this->currentPage=$currentPage;
		$this->offset=$offset;
		$this->pages=$pages;
	}

	private function setSortVars(){
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

		$this->sortBy=$sortBy;
		$this->orderBy=$orderBy;
	}

	public function showView($viewName){
		//Данные, спользуемые в представлении
		//Возможно, нужно сделать viewData объектом (MainViewData), в котором будут перечисленны обязательные переменные, используемые представлением
		$table=$this->c['table'];

		$this->viewData['students']=
			$table->getStudents(
				$this->sortBy,
				$this->orderBy,
				$this->limit,
				$this->offset,
				$this->find);
		//Генерация динамического контента для представления
		$this->viewData['viewer'] = new ViewHelper($this->currentPage,$this->sortBy,$this->orderBy,$this->find,$this->c);
		//Остальное
		$this->viewData['authorized']=$this->isAuthorized;
		if ($this->isAuthorized) {
			$this->viewData['user']=$this->user;
		}
		$this->viewData['find']=$this->find;
		$this->viewData['pages']=$this->pages;
		$this->viewData['currentPage']=$this->currentPage;
		
		parent::showView($viewName);
	}
}