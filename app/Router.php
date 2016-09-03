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
	protected $action;
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

			$this->action=array_pop($explodePath);
			if($this->action==''){
				$this->action='main';
			}
		}

	}
	
	public function getAction($url){
		return $this->action;
	}

	public function makeUrl($path){
		$projectFolder=$this->projectFolder;
		return $projectFolder.'/'.$path;
	}


	public function getControllerName($action){
		if (array_key_exists($action, $this->controllersList)) {
			return $this->controllersList[$action];
		}
		else{
			return NULL;
		}
	}
}