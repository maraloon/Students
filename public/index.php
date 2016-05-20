<?php
chdir ('../');
include ('app/bootstrap.php');


//Запускаем главный контроллер
$frontController=new FrontController();
$frontController->start();