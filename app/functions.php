<?php
/*
Однако, иногда лучше использовать именно статические методы. Они подходят для простых функций, не привязанных ни к какому объекту, не использующих поля класса, результат которых зависит только от переданных аргументов. Например, функция перевода градусов в радианы, функция, генерирующая случайный пароль или определяющая расширение по имени файла. Если такую функцию нельзя отнести к какому-то классу, ее помещают в вспомогательный класс с названием вроде Util, StringUtil или MathUtil (паттерн Utility Class).


Можно сделать интрефейс functions и в нем стат. классы ViewHelper, Config
Выозв будет таким: functions/ViewHelper::url($url); functions/Config::return();
*/

function url($url){
	return 'index.php?'.$url;
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



//Чтение JSON-конфига
function config(){
	try{
		//Подключаем конфиг
		if(!file_exists('config.json'))
			throw new ConfigException('Файла config.json не существует');
		//JSON->Object
		$config=file_get_contents('config.json',FILE_IGNORE_NEW_LINES);
		$config=json_decode($config,true);
		
		return $config;
	}
	catch(ConfigException $e){
		echo "Исключение: ", $e->getMessage(),"\n";
		return false;
	}	
		
}