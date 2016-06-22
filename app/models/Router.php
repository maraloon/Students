<?php
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router{
	function __construct(){}
	
	
	public function getModule(){
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$module=$routes[count($routes)-1];
		
		
		//Игнорирование GET-переменных
		$getStart=strpos($module,'?'); //каким символом по счету является "?"
		if($getStart){ //если есть "?" в строке
			list($module, $trash) = explode("?", $module); //записать в $module все, что до "?"
		}


		if($module==''){
			$module='main';
		}
		
		return $module;
		
	}
}