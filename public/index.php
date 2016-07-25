<?php
/*$bootstrap=realpath(__DIR__."/../app/bootstrap.php");
include ($bootstrap);*/
error_reporting(-1);
mb_internal_encoding('utf-8');
require (__DIR__.'/../vendor/autoload.php');
include (__DIR__.'/../app/container.php');
//Запускаем главный контроллер
$frontController=new Project\Controllers\FrontController($container);
$frontController->Start();