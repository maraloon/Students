<?php
/*
 * Подключение к БД
*/


/*implement
__construct
connection
*/
class DataBase{
	protected $db; //Объект PDO
	public $errors; //Ошибки подключения итд
	
	
	function __construct($dBParams){
		//подключаемся к БД через PDO
		
        $connect_str = 'mysql'
            .':host='. $dBParams['host']
            .';dbname='.$dBParams['dbname'];

			$this->db = new PDO($connect_str,$dBParams['user'],$dBParams['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));			
	}
	
	//Передаёт PDO объект
	public function connection(){
		return $this->db;
	}

	

}