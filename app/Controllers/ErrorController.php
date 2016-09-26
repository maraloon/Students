<?php
namespace StudentList\Controllers;

class ErrorController extends ViewController{

	public function errorAction(){
		$errorCode=isset($_GET['code']) ? strval($_GET['code']) : 404; //нужно ли задавать по-умолчанию 404 или выводить ошибку вызова контроллера?
		$this->viewName='http_error';
		
		//Переменные, используемые в представлении
		$router=$this->c['router'];
		//$this->ViewVars = compact('router','errorCode');
        $this->render(compact('router','errorCode'));
	}

}