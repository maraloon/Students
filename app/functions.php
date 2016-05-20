<?php
function url($url){
	return 'index.php?'.$url;
}

function randHash($count = 20){
    $result = '';
    $array = array_merge(range('a','z'), range('0','9'));
    for($i = 0; $i < $count; $i++){
        	    $result .= $array[mt_rand(0, 35)];
    }
 return $result;
}
function html($string){
	$string=htmlspecialchars($string,ENT_QUOTES);
	return $string;
}