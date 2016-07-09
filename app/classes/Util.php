<?php
/*
*
*/
namespace Project\Classes;
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

}