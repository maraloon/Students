<?php
/*
*
*/
 class JSON{

	//Чтение JSON-файла
	private static function readJSON($filename){
		//Подключаем конфиг
		if(!file_exists($filename))
			throw new ConfigException("Файла $filename не существует");
		//JSON->Array
		$array=file_get_contents($filename,FILE_IGNORE_NEW_LINES);
		$array=json_decode($array,true);
		
		return $array;
	}

	//Чтение JSON-конфига
	static function config(){
		return self::readJSON('config.json');
	}

	//Чтение JSON-роутера
	static function router(){
		return self::readJSON('router.json');
	}


}