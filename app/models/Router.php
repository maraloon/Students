<?php
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router{
	function __construct(){}
	
	
	public function getModule(){
		//$module='main';//По-умолчанию
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$module=$routes[count($routes)-1];
		
		if($module=='index.php'){
			$module='main';
		}
		
		return $module;
	}
}