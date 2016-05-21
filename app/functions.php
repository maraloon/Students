<?php
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