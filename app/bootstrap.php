<?php
//Действия, запускаемые всегда
error_reporting(-1);
mb_internal_encoding('utf-8');
//header('Content-Type: text/html; charset=utf-8');

//Считываем конфиг
try{
	if(!$config=file('config.json',FILE_IGNORE_NEW_LINES))
		throw new Exception('Файла config.json не существует');
	$config=implode('',$config);
	$config=json_decode($config);
	//print_r($config);	
}
catch(Exception $e){
	echo "Исключение: ", $e->getMessage(),"\n";
}

//Автозагрузка всех классов
function __autoload($class_name){
	require_once("app/class/".$class_name.".php");
}


//Это для теста, потом нужно удалить
include('public/list.php');