<?php
/*implement

__construct
*/
class StudentDataGateway{
	protected $db; //Объект PDO
	protected $p; //конфиг БД
	
	function __construct($db_params){
		//подключаемся к БД через PDO
        
		$this->p=$db_params; //для последующих ф-ий
		$p=@$this->p; //для удобства
		
        $connect_str = $p->driver
            .':host='. $p->host
            .';dbname='.$p->dbname;
        $this->db = new PDO($connect_str,$p->user,$p->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		//print_r($this->db);
	}
	
	//Выполняет SQL-запрос или возвращает ошибку
	//----Переделать через try catch
	function pdo_exec($rows,$func_name){
		if (!$rows->execute())
		  echo "error in function $func_name: ".__CLASS__;		
	}
	
	function getStudents(){
		//возвращает массив, где каждый students - объект Student	
		$p=@$this->p; //для удобства
		
		$rows = $this->db->prepare("SELECT * FROM `".$p->tablename."`");
		$this->pdo_exec($rows,__FUNCTION__);
		
		$students=$rows->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($students as $k=>&$v){
			$id=$v['id'];
			$name=$v['name'];
			$sname=$v['sname'];
			$group_num=$v['group_num'];
			$points=$v['points'];
			$gender=$v['gender'];
			$email=$v['email'];
			$b_year=$v['b_year'];
			$is_resident=$v['is_resident'];			
			//foreach($v as $columnName){} - надо как нибудь так сделать для сокращения, хз как
			
			$st[$id]=new Student($name,$sname,$group_num,$points,$gender,$email,$b_year,$is_resident);
		}
		
		
		return $st;
	}
}