<?php
error_reporting(-1);
mb_internal_encoding('utf-8');

/*set_exception_handler(function (Throwable $exception) {
    // Функция будет вызвана при возникновении исключения
	error_log($exception->__toString()."\n\n",0);
	$path=realpath(__DIR__.'/../public/error_pages/503.php');
	include($path);
});*/

require (__DIR__.'/../vendor/autoload.php');
include (__DIR__.'/../app/container.php');
//Запускаем главный контроллер
$frontController=new StudentList\Controllers\FrontController($container);
$frontController->Start();