<?php
/*implement

__construct
pdoExec
getStudents
addStudent
*/
class StudentDataGateway{
	protected $db; //Объект PDO
	protected $p; //конфиг БД
	public $errors; //Ошибки подключения итд
	
	
	function __construct($db_params){
		//подключаемся к БД через PDO
        
		$this->p=$db_params; //для последующих ф-ий
		$p=$this->p; //для удобства
		
        $connect_str = 'mysql'
            .':host='. $p['host']
            .';dbname='.$p['dbname'];
        $this->db = new PDO($connect_str,$p['user'],$p['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}
	
	//Выполняет SQL-запрос или возвращает ошибку
	protected function pdoExec($rows,$func_name){
		if (!$rows->execute()){
			throw new Exception("Ошибка в ф-ии $func_name: ".__CLASS__);	
		} 
	}
	
	public function getStudents(){
		//возвращает массив, где каждый students - объект Student	
		$p=$this->p; //для удобства
		
		$rows = $this->db->prepare("SELECT * FROM `students`");
		$this->pdoExec($rows,__FUNCTION__);
		
		$students=$rows->fetchAll(PDO::FETCH_ASSOC);
		
		//Подготавливаем массив
		foreach($students as $student){
			foreach($student as $columnName=>$val){
				$$columnName=$student[$columnName];
			}
			
			
			$st[$id]=new Student($name,$sname,$group_num,$points,$gender,$email,$b_year,$is_resident);
		}		
		
		return $st;
	}
	
	public function addStudent(Student $student){
		$p=$this->p;
		
		/*Сделать проверку, а нет ли такого чувака в базе по e-mail'у*/
		
		try{
			
		
			//SQL-запрос
			$rows = $this->db->prepare("INSERT INTO `students`
						(`name`,`sname`,`group_num`,`points`,`gender`,`email`,`b_year`,`is_resident`)
						VALUES (:name,:sname,:group_num,:points,:gender,:email,:b_year,:is_resident)
			");
			$rows->bindValue(':name', $student->name, PDO::PARAM_STR);
			$rows->bindValue(':sname', $student->sname, PDO::PARAM_STR);
			$rows->bindValue(':group_num', $student->group_num, PDO::PARAM_STR);
			$rows->bindValue(':points', $student->points, PDO::PARAM_INT);
			$rows->bindValue(':gender', $student->gender, PDO::PARAM_STR);
			$rows->bindValue(':email', $student->email, PDO::PARAM_STR);
			$rows->bindValue(':b_year', $student->b_year, PDO::PARAM_INT);
			$rows->bindValue(':is_resident', $student->is_resident, PDO::PARAM_STR);
			$this->pdoExec($rows,__FUNCTION__);
			
			//Если есть SQL-ошибка
			$error_array = $this->db->errorInfo();
			if($this->db->errorCode() != 0000){
				//Может создать какой-нить SQLExeption?
				throw new Exception('SQL-ошибка '.$error_array[1].': '.$error_array[2]);
			}
			
			//Получаем id записи
			//Пока это не нужно
			/*
			$get_id = $this->db->prepare("SELECT id FROM `".$p->tablename."`
										WHERE `name`=:name AND `sname`=:sname");
			$get_id->bindValue(':name', $student->name, PDO::PARAM_STR);
			$get_id->bindValue(':sname', $student->sname, PDO::PARAM_STR);
			$this->pdoExec($get_id,__FUNCTION__);
			
			$id=$get_id->fetchAll(PDO::FETCH_ASSOC);
			$id=$id[0]['id'];//приводим в удобный вид*/
			
		}
		catch(Exception $e){
			echo "Исключение: ", $e->getMessage(),"\n";
			$this->errors[0]=$e->getMessage();
		}
	}
	
}