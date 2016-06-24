<?php
/**
 * Главный контроллер
 * Решает, какой подконтроллер использовать и какие виды показывать
 *
 *
 * Проверить статус пользователя (авторизован/гость)
 * Определить нужный контроллер и вид
 * Подключить кнтроллер
 * Подключить вид
**/


class FrontController extends Controller{	
	public $isAuthorized=false; //возможно, нужно будет изменить на private



	function __construct($container){
		parent::__construct($container);

		if (isset($_COOKIE['hash'])) {
			$this->isAuthorized=$this->c['auth']->checkAuth($_COOKIE['hash']);
		}

		$components=$this->setComponents();
		/*if (!empty($components['controller'])) {

		}*/
		$components['controller'].='Controller';
		var_dump($components);
		$controller= new $components['controller']($container,$this->isAuthorized); //new RegisterController extends Controller
		$controller->showView($components['view']);

	}


	private function setComponents(){
		//Получаем текущий модуль
		$module=$this->c['router']->getModule();
		//Читаем зависимости названий контроллеров и представлений от url из JSON-файла
		$list=$this->c['routerFile'];
		//Определяем нужный контроллер и представление
		if(array_key_exists($module,$list)){
			if ( ($list[$module]['show']=='all') or
				 (  ($list[$module]['show']=='guest') and !$this->isAuthorized  ) or
					(($list[$module]['show']=='member') and $this->isAuthorized)
			){
				$controller=$list[$module]['controller'];
				$view=$list[$module]['view'];					
			}
			else{
				$controller=$list['403']['controller'];
				$view=$list['403']['view'];				
			}
		}
		else{
			$controller=$list['404']['controller'];
			$view=$list['404']['view'];
		}

		return array('controller'=>$controller,'view'=>$view);
	}

}