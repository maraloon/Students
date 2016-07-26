<?php
/*$bootstrap=realpath(__DIR__."/../app/bootstrap.php");
include ($bootstrap);*/
error_reporting(-1);
mb_internal_encoding('utf-8');

/*set_exception_handler(function (Throwable $exception) {
    // Функция будет вызвана при возникновении исключения
	error_log($exception->__toString()."\n\n",0);
	$path=realpath(__DIR__.'/../public/error_pages/503.php');
	include($path);
});*/

/*var_dump(strpos("Project\Сlasses\StudentDataGateway","Project\Classes\\"));
var_dump(strpos("Project\Сlasses\StudentDataGateway","Project\Сlasses\\"));

if ($s1===$s2) {
	echo "same";
}*/

require (__DIR__.'/../vendor/autoload.php');
include (__DIR__.'/../app/container.php');
//Запускаем главный контроллер
$frontController=new Project\Controllers\FrontController($container);
$frontController->Start();