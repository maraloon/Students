<?php
/*
Однако, иногда лучше использовать именно статические методы. Они подходят для простых функций, не привязанных ни к какому объекту, не использующих поля класса, результат которых зависит только от переданных аргументов. Например, функция перевода градусов в радианы, функция, генерирующая случайный пароль или определяющая расширение по имени файла. Если такую функцию нельзя отнести к какому-то классу, ее помещают в вспомогательный класс с названием вроде Util, StringUtil или MathUtil (паттерн Utility Class).


Можно сделать интрефейс functions и в нем стат. классы ViewHelper, Config
Выозв будет таким: functions/ViewHelper::url($url); functions/Config::return();
*/

function url($url){
	$routes = explode('/', $_SERVER['REQUEST_URI']);
	$routes[count($routes)-1]=$url;
	return implode('/', $routes);
}
//html->htmlspecialchars
function html($string){
	return htmlspecialchars($string,ENT_QUOTES);
}

function randHash($count = 20){
    $result = '';
    $array = array_merge(range('a','z'), range('0','9'));
    for($i = 0; $i < $count; $i++){
        	    $result .= $array[mt_rand(0, 35)];
    }
	
	return $result;
}

//Чтение JSON-файла
function readJSON($filename){
	//Подключаем конфиг
	if(!file_exists($filename))
		throw new ConfigException("Файла $filename не существует");
	//JSON->Array
	$array=file_get_contents($filename,FILE_IGNORE_NEW_LINES);
	$array=json_decode($array,true);
	
	return $array;
}

//Чтение JSON-конфига
function config(){
	return readJSON('config.json');
}

//Чтение JSON-роутера
function router(){
	return readJSON('router.json');
}