<?php
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router{
	protected $c;
	protected $controllerName;
	protected $viewName;
	
	function __construct($container){
		$this->c=$container;
	}
	
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


	public function getControllerName(){
		if (empty($this->controllerName)) {
			$this->setComponents();	
		}
		return $this->controllerName;
	}
	public function getViewName(){
		if (empty($this->viewName)) {
			$this->setComponents();	
		}
		return $this->viewName;
	}

	public function setComponents(){
		$isAuthorized=$this->c['auth']->checkAuth();
		//Получаем текущий модуль
		$module=$this->c['router']->getModule();
		//Читаем зависимости названий контроллеров и представлений от url из JSON-файла
		$list=$this->c['routerFile'];
		//Определяем нужный контроллер и представление
		if(array_key_exists($module,$list)){
			if ( ($list[$module]['show']=='all') or
				 (  ($list[$module]['show']=='guest') and !$isAuthorized  ) or
					(($list[$module]['show']=='member') and $isAuthorized)
			){
				$controller=$list[$module]['controller'];
				$view=$list[$module]['view'];					
			}
			else{
				include(Util::getAbsolutePath('/public/error_pages/403.php'));
				exit;
			}
		}
		else{
			include(Util::getAbsolutePath('/public/error_pages/404.php'));
			exit;
		}

		$this->controllerName=$controller;
		$this->viewName=$view;
		//return array('controller'=>$controller,'view'=>$view);
	}

}