<?php
//---Действия, запускаемые всегда---//



error_reporting(-1);
mb_internal_encoding('utf-8');
//Вспомогательные функции
require_once('functions.php');

//Ловец ошибок
set_exception_handler(function (Throwable $exception) {
    // Функция будет вызвана при возникновении исключения
	error_log($exception->__toString()."\n\n",3,'errors.log');
	include('public/503.php');
});




//Автозагрузка всех моделей
spl_autoload_register(
	function ($className) {
		// Получаем путь к файлу из имени класса
		$path = "app/models/". $className . '.php';
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