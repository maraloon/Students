<?php
namespace StudentList;
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router
{
	public $isUriValid;
	protected $module;
	protected $controllersList;
	protected $projectFolder;
	
	function __construct($controllersList,$projectFolder){
		
		
		$parsedUrl=parse_url($_SERVER['REQUEST_URI']);
		$explodePath=explode('/', $parsedUrl['path']);

		$urlPath=array(); //путь до папки public
		for ($i=1; $i < count($explodePath)-1; $i++) { 
			$urlPath[]=$explodePath[$i];
		}
		$urlPath='/'.implode('/', $urlPath);

		if ($urlPath!=$projectFolder) {
			$this->isUriValid=false;
		}
		else{
			$this->isUriValid=true;

			$this->controllersList=$controllersList;
			$this->projectFolder=$projectFolder;

			$this->module=array_pop($explodePath);
			if($this->module==''){
				$this->module='main';
			}
		}

	}
	
	public function getModule($url){
		return $this->module;
	}

	public function makeUrl($path){
		$projectFolder=$this->projectFolder;
		return $projectFolder.'/'.$path;
	}


	public function getControllerName($module){
		if (array_key_exists($module, $this->controllersList)) {
			return $this->controllersList[$module];
		}
		else{
			return NULL;
		}
	}
}