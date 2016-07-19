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
	function __construct($container){
		parent::__construct($container);
	}

	function Start(){
		$controllerName=$this->c['router']->getControllerName();
		$viewName=$this->c['router']->getViewName();
		$controller=new $controllerName($viewName,$this->c);
		$controller->parseRequest();
	}
}
