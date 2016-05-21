<?php
/**
 * Главный контроллер
 * Решает, какой подконтроллер использовать и какие виды показывать
 *
 *
 * Вероятно, подконтроллер возвращает нужное представление, а маршрутизатор его вызывает
**/
class FrontController{
	function Start(){

		//Подключаем конфиг
		$config=config();
			
		//По-умолчанию
		$controller='main';
		$view='main';
		
		//////
		//Мега-ф-ия, вовращающая статус пользовтеля: гость, авторизован
		//$authorized=is_authorized(blabla);
		$authorized=false;
		//////
		
		
		//Выбираем нужный контроллер
		//В дальнейшем index?auth будет заменено на index/auth
		//Анализ URL будет в классе Route
		if(isset($_GET['auth'])){
			if(!$authorized)
				$controller='auth';
		}
		elseif(isset($_GET['register'])){
			if(!$authorized)
				$controller='register';
		}
		elseif(isset($_GET['register_ok'])){
			if($authorized)
				$controller='register_ok';
		}
		elseif(isset($_GET['edit'])){
			if($authorized)
				$controller='edit';
		}
		
		//Подключаем контроллер
		include($config['path']['controllers'].$controller.'.php');

		//Подключаем вид
		$view=$controller; //Имя вида всегда такое же как и у контроллера
		include($config['path']['views'].$view.'.php');
			

	}
}