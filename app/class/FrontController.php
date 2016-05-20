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
		try{
			//Подключаем конфиг
			if(!file_exists('config.json'))
				throw new ConfigException('Файла config.json не существует');
			//JSON->Object
			$config=file_get_contents('config.json',FILE_IGNORE_NEW_LINES);
			$config=json_decode($config,true);
		}
		catch(ConfigException $e){
			echo "Исключение: ", $e->getMessage(),"\n";
		}
			
			
			$controller='main';
			$view='main';
			
			//////
			//Мега-ф-ия, вовращающая статус пользовтеля: гость, авторизован
			//$authorized=is_authorized(blabla);
			$authorized=false;
			//////
			
			//Подключаем контроллер
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
			
			include('public/'.$controller.'.php');

			//Подключаем вид
			$view=$controller; //Имя вида всегда такое же как и у контроллера
			include('views/'.$view.'.php');
			
			
			//Подключаем подконтроллер
			//который, возможно, использует нужные ему модели
			//include('public/table.php');	
			//Подключаем вид
			//include("views/main.php");

	}
}