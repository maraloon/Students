<?php
/*implement

__construct
addInfo
*/


class Student{
	//private $id - не знаю, нужен ли
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
		//В массиве может быть любая чушь, но принимаются хначения только с ключами как в классе
		foreach($infoArray as $key=>$value){
			if(isset($this->$key)){
				$this->$$key=$value;
			}	
		}
	}
}