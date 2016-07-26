<?php
namespace Project\Classes;
/*
* Чтение JSON-файла
*/
 class JSONLoader{
	public function readJSON($filename){
		//Подключаем конфиг
		$filename=Util::getAbsolutePath($filename);
		if(!file_exists($filename)){
			throw new ConfigException("Файла $filename не существует");
		}
		//JSON->Array
		$fileContent=file_get_contents($filename,FILE_IGNORE_NEW_LINES);
		$fileContent=json_decode($fileContent,true);
		
		if ($fileContent!=NULL) {
			return $fileContent;
		}
		else{
			throw new ConfigException("Ошибка в $filename");
		}
	}
}