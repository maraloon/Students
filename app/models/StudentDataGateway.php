<?php
/*implement

__construct
pdoExec
getStudents
getStudentByHash
checkEmail
addStudent
*/
class StudentDataGateway{
	protected $db; //Объект PDO
	public $userErrors=array(); //Ошибки, которые будут показаны пользователю
	public $systErrors=array(); //Ошибки системные, скрытые от пользователя
	
	
	
	
	function __construct(PDO $connection){
		$this->db=$connection;
	}
	
	
	
	
	
	
	
	//Выполняет SQL-запрос или выкидывает ошибку
	protected function pdoExec($rows,$func_name){

		if (!$rows->execute()){
			throw new StudentDataGatewayException("Ошибка в ф-ии $func_name: ".__CLASS__);	
		} 
	}
	
	
	
	
	
	
	
	
	
	public function getStudents(){
		//возвращает массив, где каждый studentsRows - объект Student	
		
		$rows = $this->db->prepare("SELECT * FROM `students`");
		$this->pdoExec($rows,__FUNCTION__);
		
		$studentsRows=$rows->fetchAll(PDO::FETCH_ASSOC);
		
		//Подготавливаем массив
		$students=array();
		foreach($studentsRows as $studentRow){
			$students[]=new Student();		
			$students[count($students)-1]->addInfo($studentRow);
		}		
		
		return $students;
	}
	
	
	
	
	
	//Принимает хеш. Возвращает имя, фамилию. И email для идентификации пользователя (см. вид)
	public function getStudentByHash($hashFromCookie){
		$rows = $this->db->prepare("SELECT `name`,`sname`,`email` FROM `students` WHERE `hash`=:hash");
		$rows->bindValue(':hash', $hashFromCookie, PDO::PARAM_STR);
		$this->pdoExec($rows,__FUNCTION__);

		$studentRow=$rows->fetchAll(PDO::FETCH_ASSOC);
		
		$student=array();
		$student['user']=$studentRow[0]['name'];
		$student['suser']=$studentRow[0]['sname'];
		$student['email']=$studentRow[0]['email'];
		return $student;
	}
	
	
	
	//Проверка на существование e-mail'а
	private function checkEmail($email){
		$rows = $this->db->prepare("SELECT * FROM `students` WHERE `email`=:email");
		$rows->bindValue(':email', $email, PDO::PARAM_STR);
		$this->pdoExec($rows,__FUNCTION__);

		$studentRow=$rows->fetchAll(PDO::FETCH_ASSOC);	
		
		if( (count($studentRow)) > 0){
			$status=false;
		}
		else{
			$status=true;
		}
		
		return $status;
	}	
	
	
	
	
	
	//Добавляет новую строку в БД
	public function addStudent(Student $student){		
		//Проверяет, а нет ли  в базе такого e-mail'а
		$alredyRegistered=$this->checkEmail($student->email);
		if(!$alredyRegistered){
			$this->userErrors[]='Такой e-mail уже зарегистрирован';
			return;
		}

		//SQL-запрос
		$rows = $this->db->prepare("INSERT INTO `students`
					(`name`,`sname`,`group_num`,`points`,`gender`,`email`,`b_year`,`is_resident`,`hash`)
					VALUES (:name,:sname,:group_num,:points,:gender,:email,:b_year,:is_resident,:hash)
		");
		$rows->bindValue(':name', $student->name, PDO::PARAM_STR);
		$rows->bindValue(':sname', $student->sname, PDO::PARAM_STR);
		$rows->bindValue(':group_num', $student->group_num, PDO::PARAM_STR);
		$rows->bindValue(':points', $student->points, PDO::PARAM_INT);
		$rows->bindValue(':gender', $student->gender, PDO::PARAM_STR);
		$rows->bindValue(':email', $student->email, PDO::PARAM_STR);
		$rows->bindValue(':b_year', $student->b_year, PDO::PARAM_INT);
		$rows->bindValue(':is_resident', $student->is_resident, PDO::PARAM_STR);
		$rows->bindValue(':hash', $student->hash, PDO::PARAM_STR);
		$this->pdoExec($rows,__FUNCTION__);
		
		//Если есть SQL-ошибка
		$error_array = $this->db->errorInfo();
		if($this->db->errorCode() != 0000){
			throw new StudentDataGatewayException('SQL-ошибка '.$error_array[1].': '.$error_array[2]);
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
	
		
}