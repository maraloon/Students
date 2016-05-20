<?php
//Действия, запускаемые всегда
error_reporting(-1);
mb_internal_encoding('utf-8');

//Вспомогательные функции
require_once('functions.php');



//Автозагрузка всех классов/моделей
spl_autoload_register(
	function ($className) {
		// Получаем путь к файлу из имени класса
		$path = "app/class/". $className . '.php';
		if (file_exists($path)) {
			require_once $path;
		}
	}
);
//Автозагрузка всех Exeption
spl_autoload_register(
	function ($className) {
		// Получаем путь к файлу из имени класса
		$path = "app/exeptions/". $className . '.php';
		if (file_exists($path)) {
			require_once $path;
		}
	}
);