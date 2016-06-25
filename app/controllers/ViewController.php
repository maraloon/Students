<?php

abstract class ViewController  extends Controller{
	protected $viewData;

	public function showView($view){
		$path=array(
				'views'=>'app/views/',
				'css'=>'public/src/style.css'
				);
		//распаковываем массив в переменные
		//if (isset($this->viewData)) {
			foreach ($this->viewData as $key => $value) {
				$$key=$value;
			}
		//}


		//Показываем страницу
		foreach ($path as &$file) {
			$file=Util::getAbsolutePath($file);
		}

		$cssFile=$path['css'];
		include($path['views'].'/modules/header.php');
		//include($path['views'].'/pages/'.$view.'.php');
		include($path['views'].'/'.$view.'.php');
		include($path['views'].'/modules/footer.php');
	}
}