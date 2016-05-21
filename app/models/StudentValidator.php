<?php
class StudentValidator{
	public $errors=array(); //Errors
	
	
	/* Непонятная ошибка: Constant expression contains invalid operations
	public $year=date("Y");
	public $yearint=(int) $year;
	*/
	private $masks=array(
		//string, regexp, min(mb_strlen),max(mb_strlen)
		//int, min(value),max(value)
		//enum, array(values)
		'name'=>array('string',"/^[а-яa-z ']+$/iu",1,200), //Эта рег-ка пропускает ''''''' и множество пробелов. Исправить
		'sname'=>array('string',"/^[а-яa-z ']+$/iu",1,200),
		'group_num'=>array('string',"/^[а-яa-z0-9]+$/iu",2,5),
		'points'=>array('int',0,300),
		'gender'=>array('enum',array('m','f')),
		'email'=>array('string',"/\@/u",3,200), //Почему такая регулярка: https://habrahabr.ru/post/175375/
		'b_year'=>array('int',1900,2016),
		'is_resident'=>array('enum',array('resident','foreign'))
	);
	

	/* //Как вариант
	private $masks=array(
		'name'=>array(
			'type'=>'string',
			'regexp'=>"/^[а-яa-z ']+$/iu",
			'min' => 1,
			'max' => 200
		),
		//...
	);
	*/
	
	function __construct(Student $s){
		$masks=@$this->masks;
		$e=array();
		
		foreach($masks as $field=>$mask){			
			if($mask[0]=='string'){

				if(!preg_match($mask[1],$s->$field)){
					$e[]='Поле '.$field.' не соответствует маске'.$mask[1];
				}
				if(mb_strlen($s->$field)<$mask[2]){
					$e[]='В поле '.$field.' должно быть минимум '.$mask[2].' символов';
				}
				if(mb_strlen($s->$field)>$mask[3]){
					$e[]='В поле '.$field.' должно быть максимум '.$mask[3].' символов.';
				}
				
			}
			elseif($mask[0]=='int'){
				
				if(!is_numeric($s->$field)){
					$e[]='Поле '.$field.' должно быть числом';
				}
				
				if($s->$field<$mask[1]){
					$e[]='Минимальное значение поля '.$field.' - это '.$mask[1];
				}
				elseif($s->$field>$mask[2]){
					$e[]='Максимальное значение поля '.$field.' - это '.$mask[2];
				}
				
			}
			elseif($mask[0]=='enum'){
				$inList=false; //переданное значение не соответствует ни одному шаблону
				foreach($mask[1] as $value){
					
					if($s->$field=$value){
						$inList=true; //нашелся один соответствующий
					}
	
				}
				
				if (!$inList){
					$e[]='Значение поля '.$field.' не '.implode(' и не ',$mask[1]);					
				}

				
			}
		}
		
		//Передаём массив ошибок из ф-ии объекту
		$this->errors=$e;
	}

}