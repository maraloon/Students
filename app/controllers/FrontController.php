<?php
namespace StudentList\Controllers;
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
		$controllerName='\StudentList\Controllers\\'.$this->c['router']->getControllerName();
		//$viewName=$this->c['router']->getViewName();
		$module=$this->c['router']->getModule();
		$controller=new $controllerName($module,$this->c);
		$controller->parseRequest();
	}
}
