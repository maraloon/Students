<?php
/*
*
*/
class Util{


	static function randHash($count = 20){
	    $result = '';
	    $array = array_merge(range('a','z'), range('0','9'));
	    for($i = 0; $i < $count; $i++){
	        	    $result .= $array[mt_rand(0, 35)];
	    }
		
		return $result;
	}

	/*static function setToken(){
		if(!isset($_COOKIE['token'])){
			$token=Util::randHash(20);
			setcookie('token',$token,time()+3600,'/',null,false,true);
		}
		else{
			$token=$_COOKIE['token'];
			setcookie('token',$token,time()+3600,'/',null,false,true);
		}

		return $token;
	}*/

}