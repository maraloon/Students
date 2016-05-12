<?php
class StudentValidator{
	function __construct(Student $s){
		$e=array(); //Errors
		//Check name
		/*if(регулярка)
			$e[]="Имя может состоять из латиницы, кириллицы, пробелов и одинарной кавычки";	*/
		if(strlen($s->name)>200)
			$e[]="Имя не должно занимать больше 200 символов, а у вас оно заняло".strlen($s->name);
		/*итд*/
		
		return $e;
	}
}