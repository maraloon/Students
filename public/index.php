<?php
$bootstrap=realpath(__DIR__."/../app/bootstrap.php");
include ($bootstrap);
//Запускаем главный контроллер
$frontController=new FrontController($container);
$frontController->Start();