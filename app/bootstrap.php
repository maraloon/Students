<?php
//Действия, запускаемые всегда
error_reporting(-1);
mb_internal_encoding('utf-8');
//header('Content-Type: text/html; charset=utf-8');

try{
	//Считываем конфиг
	if(!file_exists('config.json'))
		throw new Exception('Файла config.json не существует');

	$config=file('config.json',FILE_IGNORE_NEW_LINES);
 	$config=implode('',$config);
	$config=json_decode($config);
	
	//Автозагрузка всех классов
	function __autoload($class_name){
		require_once("app/class/".$class_name.".php");
	}
	
	/*
		В будущем вместо строк ниже тут должна распологаться решение,
		какую модель подключить и какой вид показать.
		А еще лучше вывести это в отдельный файл, типа route.php
	*/
	//Подключаем модель
	include('public/list.php');	
	//Подключаем вид
	include("views/list.php");
}
catch(Exception $e){
	echo "Исключение: ", $e->getMessage(),"\n";
}


