<?php
/*
*
*/
class ViewHelper{
	public $page;
	public $sortBy;
	public $orderBy;



	function __construct($page,$sortBy,$orderBy){
		$this->page=$page;
		$this->sortBy=$sortBy;
		$this->orderBy=$orderBy;
	}



	function makeUrl(Array $params){
		$urlVars= array('page' => $this->page, 'sortBy' => $this->sortBy,'orderBy' => $this->orderBy);
		$blockedParams=array_diff_key($urlVars,$params); //ключи что есть в $urlVars, но нет в $params
		//возможно эти 2 строчки нужно в main.php и передавать уже строку в конструктор
		$router=new Router();
		$module=$router->getModule();

		$url=$module."?";
		
		//вставляем гет-переменные, которые не нужно менять
		foreach ($blockedParams as $key => $value) {
				$url.=$key."=".$value."&";		
		}
		//вставляем гет-переменные с новыми значениями
		$url.=http_build_query($params);

		return html($url);
	}





	//Меняет или добавляет в текущий url значение переменоых sortBy, orderBy
	function makeSortUrl($row){
		$sortBy=$this->sortBy;
		$orderBy=$this->orderBy;

		if ($row==$sortBy) { //если таблица уже отсортирована по этому столбцу
			$orderBy = $orderBy=='asc' ? 'desc' : 'asc'; //изменить порядок
		}

		return $this->makeUrl(array('sortBy'=>$row,'orderBy'=>$orderBy));
	}





	//Меняет или добавляет в текущий url значение переменой page
	function makePageUrl($row){
		return $this->makeUrl(array('page'=>$row));
	}







	function showSortOrder($row){
		if ($row==$this->sortBy) {
			return $this->orderBy=='asc' ? '[▲]' : '[▼]';
		}
	}

}