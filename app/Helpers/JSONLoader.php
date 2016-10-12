<?php
namespace StudentList\Helpers;
use StudentList\Exceptions\ConfigException;
/*
* Чтение JSON-файла
*/
 class JSONLoader{
    public function readJSON($filename){
        //Подключаем конфиг
        $filename=Util::getAbsolutePath($filename);
        if(!file_exists($filename)){
            throw new ConfigException("Файл $filename не существует");
        }
        //JSON->Array
        $fileContent=file_get_contents($filename,FILE_IGNORE_NEW_LINES);
        $fileContent=json_decode($fileContent,true);

        if ($fileContent!=NULL) {
            return $fileContent;
        }
        else{
            throw new ConfigException("Ошибка в $filename: ",json_last_error());
        }
    }
}