<?php
/*
*
*/
class ViewHelper{
	public $page;
	public $sortBy;
	public $orderBy;
	public $find;



	function __construct($page,$sortBy,$orderBy,$find){
		$this->page=$page;
		$this->sortBy=$sortBy;
		$this->orderBy=$orderBy;
		$this->find=$find;
	}





	static function url($url){
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$routes[count($routes)-1]=$url;
		return implode('/', $routes);
	}


	//html->htmlspecialchars
	static function html($string,$find=NULL){
		$string=htmlspecialchars($string,ENT_QUOTES);

		//Обозначать цветом найденную подстроку
		if (isset($find)) {
			$reg="/$find/ui";
			$string=preg_replace($reg, "<font style='background-color: yellow;'>$0</font>", $string);
		}

		return $string;
	}




	function makeUrl(Array $params){
		$urlVars= array('page' => $this->page, 'sortBy' => $this->sortBy,'orderBy' => $this->orderBy,'find' => $this->find);
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

		return self::html($url);
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