<?php
//Действия, запускаемые всегда
error_reporting(-1);
mb_internal_encoding('utf-8');


function url($url){
	return 'index.php?'.$url;
}

//Автозагрузка всех классов/моделей
//Добавить try/catch на file_exists
function __autoload($className){
	require_once("app/class/".$className.".php");
}
Route::start();