<?php
namespace Project\Classes;
class StudentValidator{
	protected $errors=array();
	protected $c;
	
	private $masks=array(
		'name'=>array(
			'type'=>'string',
			'regexp'=>"/^([а-яa-z][ ']*)+$/iu",
			'min' => 1,
			'max' => 200,
			'name' => 'Имя',
			'message' => 'должно состоять из кириллицы или латиницы, может содержать знак \' и пробел'
		),
		'sname'=>array(
			'type'=>'string',
			'regexp'=>"/^([а-яa-z][ ']*)+$/iu",
			'min' => 1,
			'max' => 200,
			'name' => 'Фамилия',
			'message' => 'должна состоять из кириллицы или латиницы, может содержать знак \' и пробел'
		),
		'group_num'=>array(
			'type'=>'string',
			'regexp'=>"/^[а-яa-z0-9]+$/iu",
			'min' => 2,
			'max' => 5,
			'name' => 'Номер группы',
			'message' => 'должен состоять из кириллицы, латиницы или цифр'
		),
		'points'=>array(
			'type'=>'int',
			'min' => 0,
			'max' => 300,
			'name' => 'Кол-во баллов',
			'message' => 'должно быть от 0 до 300'
		),
		'gender'=>array(
			'type'=>'enum',
			'values' => array('m','f'),
			'message' => 'Выбран неверный параметр в Мужской/Женский пол'
		),
		'email'=>array(
			'type'=>'string',
			'regexp'=>"/\@/u",
			'min' => 3,
			'max' => 200,
			'name' => 'E-mail',
			'message' => 'должен содержать знак @'
		),
		'b_year'=>array(
			'type'=>'int',
			'min' => 1900,
			'max' => 2016,
			'name' => 'Год рождения',
			'message' => 'должнен быть от 1900 до 2016'
		),
		'is_resident'=>array(
			'type'=>'enum',
			'values' => array('resident','foreign'),
			'message' => 'Выбран неверный параметр в Местный/Иногородний'
		),
	);
	
	
	function __construct(Student $s, $container, $id=NULL){
		$this->c=$container;
		$masks=$this->masks;
		$e=array();
		
		foreach($masks as $field=>$mask){			
			if($mask['type']=='string'){

				if(!preg_match($mask['regexp'],$s->$field)){
					$e[]=$mask['name'].' '.$mask['message'];
				}
				if(mb_strlen($s->$field)<$mask['min']){
					$e[]=$mask['name'].' должно быть минимум '.$mask['min'].' символов';
				}
				if(mb_strlen($s->$field)>$mask['max']){
					$e[]=$mask['name'].' должно быть максимум '.$mask['max'].' символов.';
				}
				
			}
			elseif($mask['type']=='int'){
				
				if(!is_numeric($s->$field)){
					$e[]='Поле '.$mask['name'].' должно быть числом';
				}
				
				if(  ($s->$field<$mask['min'])  or  ($s->$field>$mask['max'])   ){
					$e[]=$mask['name'].' '.$mask['message'];
				}
				
			}
			elseif($mask['type']=='enum'){
				$inList=false; //переданное значение не соответствует ни одному шаблону
				foreach($mask['values'] as $value){
					
					if($s->$field=$value){
						$inList=true; //нашелся один соответствующий
					}
	
				}
				
				if (!$inList){
					$e[]=$mask['message'];					
				}

				
			}
		}

		if (($this->checkEmail($s->email,$id))) {
			$e[]='Такой e-mail уже зарегистрирован';
		}
		
		//Передаём массив ошибок из ф-ии объекту
		$this->errors=$e;
	}

	//Проверяет, а нет ли  в базе такого e-mail'а
	public function checkEmail($email,$id=NULL){

		$isAlredyRegistered=$this->c['table']->checkEmail($email,$id);
		return $isAlredyRegistered;
	}


	public function getErrors(){
		return $this->errors;
	}
}