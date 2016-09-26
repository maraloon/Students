<?php
namespace StudentList;
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router
{
	protected $isUriValid;
	protected $action;
	protected $controllersList;
	protected $projectFolder;
	
	function __construct($controllersList,$projectFolder,$url){	
		
		$parsedUrl=parse_url(trim($url,'/'));
		$explodePath=explode('/', $parsedUrl['path']);
		$urlPath=array_slice($explodePath, 0,2);
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
	
	public function getAction(){
		return $this->action;
	}

	public function makeUrl($path){
		$projectFolder=$this->projectFolder;
		return $projectFolder.'/'.$path;
	}

	public function isUriValid(){
		return $this->isUriValid;
	}

	public function getControllerName(){
		$action=$this->getAction();
		if (array_key_exists($action, $this->controllersList)) {
			return $this->controllersList[$action];
		}
		else{
			return NULL;
		}
	}
}