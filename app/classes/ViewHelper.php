<?php
/*
*
*/
/*
class ViewHelper{
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
}*/