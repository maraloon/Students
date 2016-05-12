<?php
/*implement

__construct
*/


class Student{
	//private $id - не знаю, нужен ли
	private $name; //string(200)
	private $sname; //string(200)
	private $group_num; //string(5)
	private $points; //integer; 0-300
	private $gender; //bool; 1 - male, 0 - female
	private $email; //string(200); [a-z]@[a-z].[a-z]{3}
	private $b_year; //string(4); 1900-2016
	private $is_resident; //bool; 1 - resident, 0 - nonresident;
	
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