<?php

abstract class ViewController  extends Controller{
	function __construct($container){
		parent::__construct($container);
	}


	public function showView($view,$viewData){
		$path=array(
				'views'=>'app/views/',
				'css'=>'public/src/style.css'
				);


		//распаковываем массив в переменные
		foreach ($viewData as $key => $value) {
			$$key=$value;
		}

		//Показываем страницу
		foreach ($path as &$file) {
			$file=Util::getAbsolutePath($file);
		}

		$cssFile=$path['css'];
		include($path['views'].'/modules/header.php');
		include($path['views'].'/pages/'.$view.'.php');
		include($path['views'].'/modules/footer.php');
	}
}