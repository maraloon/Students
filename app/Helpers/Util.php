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

    static function setCsrfToken(){
        $token=(isset($_COOKIE['token'])) ? $_COOKIE['token'] : static::randHash(20);
        setcookie('token',$token,time()+3600,'/',null,false,true);
        return $token;
    }

    static function checkCsrfToken(){
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
            $find=preg_quote($find,"/"); //экранируем слешы и пр.
            $find="/".$find."/ui"; //теперь это регулярка
            $string=preg_replace($find, "<mark>$0</mark>", $string);
        }
        return $string;
    }
}