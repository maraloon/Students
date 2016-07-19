<?php
/*
*
*/
class ViewHelper{
	public $page;
	public $sortBy;
	public $orderBy;
	public $find;
	protected $router;

	function __construct($page,$sortBy,$orderBy,$find,$router){
		$this->page=$page;
		$this->sortBy=$sortBy;
		$this->orderBy=$orderBy;
		$this->find=$find;
		$this->router=$router;
	}

	//html->htmlspecialchars
	static function html($string){
		return htmlspecialchars($string,ENT_QUOTES);
	}

	//Обозначать цветом найденную подстроку
	static function highlight($string,$find=NULL){
		if($find!=NULL){
		$reg=preg_quote("/$find/ui");
		$string=preg_replace($reg, "<font style='background-color: yellow;'>$0</font>", $string);
		}
		return $string;
	}

	function makeUrl(Array $params){
		$urlVars= array('page' => $this->page, 'sortBy' => $this->sortBy,'orderBy' => $this->orderBy,'find' => $this->find);
		$blockedParams=array_diff_key($urlVars,$params); //ключи что есть в $urlVars, но нет в $params
		$module=$this->router->getModule();
		
		$url=$module."?".http_build_query(array_merge($blockedParams,$params));
		return $url;
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
		else{
			return false;
		}
	}

}