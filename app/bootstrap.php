<?php
//---Действия, запускаемые всегда---//

error_reporting(-1);
mb_internal_encoding('utf-8');


//Ловец ошибок
/*set_exception_handler(function (Throwable $exception) {
    // Функция будет вызвана при возникновении исключения
	//error_log($exception->__toString()."\n\n",3,'errors.log');
	error_log($exception->__toString()."\n\n",0);
	include('../public/error_pages/503.php');
});*/




//Автозагрузка всех моделей
spl_autoload_register(
	function ($className) {
		// Получаем путь к файлу из имени класса
		$folders=array('classes','exeptions','controllers');

		foreach ($folders as $folder) {
			$path = "../app/$folder/$className.php";
			if (file_exists($path)) {
				require_once $path;
			}
		}
	}
);



//Подключаем сторонние библиотеки
require Util::getAbsolutePath('vendor/autoload.php');
//DI container
include Util::getAbsolutePath('app/container.php');
