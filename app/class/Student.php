<?php
/*implement

__construct
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
	/*public $hash; её, с большой вероятностью нужно сделать protected*/
	
	function __construct($name,$sname,$group_num,$points,$gender,$email,$b_year,$is_resident){
		$this->name=$name;
		$this->sname=$sname;
		$this->group_num=$group_num;
		$this->points=$points;
		$this->gender=$gender;
		$this->email=$email;
		$this->b_year=$b_year;
		$this->is_resident=$is_resident;

		//$validator=new StudentValidator($this); //вероятно, вызывать валидатор надо не здесь
	}
}