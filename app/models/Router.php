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
		
		if( ($module=='index.php') or ($module=='')){
			$module='main';
		}
		
		return $module;
		
	}
}