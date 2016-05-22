<?php
/*implement

__construct
addInfo
*/


class Student{
	//private $id; //- не знаю, нужен ли
	public $name; //string(200)
	public $sname; //string(200)
	public $group_num; //string(5)
	public $points; //integer; 0-300
	public $gender; //bool; 1 - male, 0 - female
	public $email; //string(200); [a-z]@[a-z].[a-z]{3}
	public $b_year; //string(4); 1900-2016
	public $is_resident; //bool; 1 - resident, 0 - foreign;
	public $hash; //её, с большой вероятностью нужно сделать не здесь, нужен совет ОПа*/
	
	function __construct(){}
	
	public function addInfo($infoArray){
		//В массиве может быть любая чушь, но принимаются значения только с ключами как в классе		
		foreach($infoArray as $key=>$value){			
			$object_vars=get_object_vars ($this);
			//Если есть переменная в объекте
			if(array_key_exists($key,$object_vars)){
				//Если значение из массива не пустое
				if(isset($value) and ($value!=NULL)){
					//Передать значение объекту
					$this->$key=$value;
				}
				
			}

		}
	}
}