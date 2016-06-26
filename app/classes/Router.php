<?php
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router{
	function __construct(){}
	
	public function getModule(){
		$parsedUrl=parse_url($_SERVER['REQUEST_URI']);
		$explodePath=explode('/', $parsedUrl['path']);
		$module=$explodePath[count($explodePath)-1];

		if($module==''){
			$module='main';
		}
		
		return $module;
		
	}

	static function url($url){
		$explodePath = explode('/', $_SERVER['REQUEST_URI']);
		$explodePath[count($explodePath)-1]=$url;
		return implode('/', $explodePath);
	}
}