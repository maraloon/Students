<?php
namespace StudentList\Helpers;
/*
*
*/
class Util{
	static function randHash($count = 20){
	    $result = '';
	    $array = array_merge(range('a','z'), range('0','9'));
	    for($i = 0; $i < $count; $i++){
	        	    $result .= $array[mt_rand(0, count($array))];
	    }
		
		return $result;
	}

	static function getAbsolutePath($file){
		return realpath(__DIR__.'/../../'.$file);
	}

	//html->htmlspecialchars
	static function html($string){
		return htmlspecialchars($string,ENT_QUOTES);
	}

	//Обозначать цветом найденную подстроку
	static function highlight($string,$find=NULL){
		if($find!=NULL){
		$reg=preg_quote("/$find/ui");
		$string=preg_replace($reg, "<font style='background-color: yellow;'>$0</font>", $string);
		}
		return $string;
	}
}