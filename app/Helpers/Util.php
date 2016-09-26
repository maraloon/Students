<?php
namespace StudentList\Helpers;
/*
*
*/
class Util{
	static function randHash($count = 20){
	    $result='';
	    $array=array_merge(range('a','z'),range('0','9'));
	    for($i=0; $i < $count; $i++){
			$result.=$array[mt_rand(0,count($array)-1)];
	    }
		
		return $result;
	}

	static function setToken(){
		$token=(isset($_COOKIE['token'])) ? $_COOKIE['token'] : static::randHash(20);
		setcookie('token',$token,time()+3600,'/',null,false,true);
		return $token;
	}

	static function checkToken(){
		if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!==$_POST['token']) ){
			return false;
		}
		return true;
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
			//$find="Хи/г\\о";
			//$find=addslashes($find);
			//var_dump($find);
			$reg=preg_quote("/$find/ui");
			$string=preg_replace($reg, "<font style='background-color: yellow;'>$0</font>", $string);
		}
		return $string;
	}
}