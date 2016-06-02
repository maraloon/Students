<?php

class Sort{
	
	public $sortBy;
	public $orderBy;


	function __construct($sortBy,$orderBy){
			$this->sortBy=$sortBy;
			$this->orderBy=$orderBy;
	}

	function makeSortUrl($row){
		if ($row==$this->sortBy) { //если таблица уже отсортирована по этому столбцу
			$this->orderBy= $this->orderBy=='asc' ? 'desc' : 'asc'; //изменить порядок
		}

		//Определяем текущий модуль
		$router=new Router();
		$module=$router->getModule();
		//готовим ссылку без get-переменных
		$url=url("$module?");
		
		//удаляем текущие "сортировочные гет-переменные
		if (isset($_GET['sortBy'])){
			unset($_GET['sortBy']);
		}
		if (isset($_GET['orderBy'])){
			unset($_GET['orderBy']);
		}
		//вставляем гет-переменные, не связанные с сортировкой
		foreach ($_GET as $key => $value) {
			$url.=$key."=".$value."&";
		}
		//вставляем новые "сортировочные"" гет-переменные
		$url.=http_build_query([
			'sortBy'=>$row,
			'orderBy'=>$this->orderBy
			]);

		return html($url);
	}

	function getVisual($row){
		//
		if ($row==$this->sortBy) {
			if ($this->orderBy=='asc') {
				echo '[▲]';
			}
			else{
				echo '[▼]';
			}
		}
	}
}