<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;

/**
 * Front Controller
 * 
 * It's really cool stuff, man!
 */
class FrontController extends Controller{

	/**
	 * Constructor
	 * 
	 * @param array $container Pimple Container
	 */
	function __construct($container){
		parent::__construct($container);
	}

	/**
	 * Starting this megascript
	 */
	function Start(){
		if ($this->c['router']->isUriValid) {
			$controllerName=$this->c['router']->getControllerName($this->c['action']);
			if ($controllerName!=NULL) {
				$controllerPath='\StudentList\Controllers\\'.$controllerName;
				$controller=new $controllerPath($this->c);

				$actionFunc=$this->c['action'].'Action';
				if (method_exists($controller, $actionFunc)) {

					$error=$controller->$actionFunc();
					if ($error==NULL) {
						$controller->showView();
					}
					else{
						include(Util::getAbsolutePath("/public/error_pages/$error.php"));
					}
				}
				else{
					include(Util::getAbsolutePath('/public/error_pages/404.php'));
					//Вывести в лог ошибку, что неправильно написан контроллер или в роутере прописан несуществующее представление
				}
			}
			else{
				include(Util::getAbsolutePath('/public/error_pages/404.php'));
			}
		}
		else{
			include(Util::getAbsolutePath('/public/error_pages/404.php'));
		}

	}
}
