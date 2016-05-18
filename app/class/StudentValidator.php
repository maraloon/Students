<?php
class StudentValidator{
	$errors=array(); //Errors

$mask=array(
	//string, regexp, min(strlen),max(strlen)
	//int, min(value),max(value)
	'name'=>array('string',"/[а-яa-z ']/iu",1,200),
	'sname'=>array('string',"/[а-яa-z ']/iu",1,200),
	'group_num'=>array('string',"/[а-яa-z0-9]/iu",2,5),
	'points'=>array('int',0,300),
	'gender'=>array('bool'),
	'email'=>array('string',"/\@/u",200), //Почему такая регулярка: https://habrahabr.ru/post/175375/
	'b_year'=>array('int',1900,date('Y')),
	'is_resident'=>array('bool');
);
	
	function __construct(Student $s){
		$e=array(); //Errors
		//Имя
		if(preg_match("/[а-яa-z ']/iu",$s->name)
			$e[]="Имя может состоять из латиницы, кириллицы, пробелов и одинарной кавычки";
		if(strlen($s->name)>200)
			$e[]="Имя не должно занимать больше 200 символов, а у вас оно заняло".strlen($s->name);
		//Фамилия
		if(preg_match("/[а-яa-z ']/iu",$s->sname)
			$e[]="Фамилия может состоять из латиницы, кириллицы, пробелов и одинарной кавычки";
		if(strlen($s->name)>200)
			$e[]="Фамилия не должна занимать больше 200 символов, а у вас оно заняло".strlen($s->sname);
		/*итд*/
		
		return $e;
	}
}