<?php
error_reporting(-1);
mb_internal_encoding('utf-8');

/**
 * Ловит исключения
 */
/*set_exception_handler(function (Throwable $exception) {
    error_log($exception->__toString()."\n\n",0);
    $path=realpath(__DIR__.'/../public/error_pages/503.php');
    include($path);
});*/

/**
 * Автозагрузчик Composer
 */
require (__DIR__.'/../vendor/autoload.php');

/**
 * Контейнер Pimple
 */
include (__DIR__.'/../app/container.php');

/**
 * Запуск главного контроллера
 */
$frontController=new StudentList\Controllers\FrontController($container);
$frontController->start();