<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;
/**
 * Главный контроллер
 * Решает, какой подконтроллер использовать и какие виды показывать
 *
 * Определить нужный контроллер и вид
 * Подключить кнтроллер
 * Подключить вид
**/
class FrontController extends Controller{

	function __construct($container){
		parent::__construct($container);
	}

	function Start(){
		if ($this->c['router']->isUriValid) {
			$controllerName=$this->c['router']->getControllerName($this->c['module']);
			if ($controllerName!=NULL) {
				$controllerPath='\StudentList\Controllers\\'.$controllerName;
				$controller=new $controllerPath($this->c);

				$moduleFunc=$this->c['module'].'Module';
				if (method_exists($controller, $moduleFunc)) {

					$error=$controller->$moduleFunc();
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
