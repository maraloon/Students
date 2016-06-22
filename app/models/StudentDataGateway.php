<?php
/*implement

__construct
pdoExec
countStudents
private function getColumns
getStudents
getStudentByHash
checkEmail
addStudent
editStudent
*/
class StudentDataGateway{




	protected $db; //Объект PDO
	public $userErrors=array(); //Ошибки, которые будут показаны пользователю
	
	
	
	
	function __construct(PDO $connection){
		$this->db=$connection;
	}
	
	

	
	
	
	
	//Выполняет SQL-запрос или выкидывает ошибку
	protected function pdoExec($rows,$func_name){

		if (!$rows->execute()){
			throw new StudentDataGatewayException("Ошибка в ф-ии $func_name: ".__CLASS__);	
		} 
	}
	
	





	/* Кол-во записей в таблице
	*
	* Если $search=NULL
	*	Вернуть кол-во всех строк таблицы
	* Иначе
	*	Вернуть кол-во строк, в которых есть вхождение $search
	*
	*/
	public function countStudents($search=NULL){

		$rows = $this->db->prepare("SELECT COUNT(*) FROM `students`");

		//Если задан поиск по строке $search
		if (isset($search)) {
			$rows = $this->db->prepare("SELECT COUNT(*) FROM `students` WHERE CONCAT(`name`,' ',`sname`,' ',`group_num`,' ',`points`,' ',`gender`,' ',`email`,' ',`b_year`,' ',`is_resident`) LIKE '%$search%'");
		}
		

		
		$this->pdoExec($rows,__FUNCTION__);

		$count=$rows->fetchAll(PDO::FETCH_ASSOC);
		return $count[0]["COUNT(*)"];
	}	
	
	
	
	private function getColumns(){
		$rows = $this->db->prepare("SHOW COLUMNS FROM `students`");
		$this->pdoExec($rows,__FUNCTION__);
		$columns=$rows->fetchAll(PDO::FETCH_ASSOC);
		foreach ($columns as &$column) {
			$column=$column["Field"];
		}

		return $columns;
	}
	
	public function getStudents($sortBy,$orderBy,$limit,$offset,$search=NULL){
		/*
		* возвращает массив, где каждый studentsRows - объект Student
		* $limit записей, начиная с $offset
		*/
		//Фильтруем данные
		if(!in_array($sortBy, $this->getColumns())){
			$sortBy='points';
		}
		$orderBy= $orderBy=='asc'? 'asc' : 'desc'; //если передаётся шняга, то desc

		
		//Формируем строку запроса
		$rows = $this->db->prepare("SELECT * FROM `students` ORDER BY $sortBy $orderBy LIMIT :y OFFSET :x");
		//Если задан поиск по строке $search
		if (isset($search)) {
			$rows = $this->db->prepare("SELECT * FROM `students` WHERE CONCAT(`name`,' ',`sname`,' ',`group_num`,' ',`points`,' ',`gender`,' ',`email`,' ',`b_year`,' ',`is_resident`) LIKE '%$search%' ORDER BY $sortBy $orderBy LIMIT :x,:y");
		}


		$rows->bindValue(':y', $limit, PDO::PARAM_INT);
		$rows->bindValue(':x', $offset, PDO::PARAM_INT);

		$this->pdoExec($rows,__FUNCTION__);
		
		$studentsRows=$rows->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($studentsRows);
		//Подготавливаем массив
		$students=array();
		foreach($studentsRows as $studentRow){
			$students[]=new Student();		
			$students[count($students)-1]->addInfo($studentRow);
		}
		return $students;
	}
	
	
	
	
	//Принимает хеш. Возвращает строку студента
	public function getStudentByHash($hashFromCookie){
		$rows = $this->db->prepare("SELECT * FROM `students` WHERE `hash`=:hash");
		$rows->bindValue(':hash', $hashFromCookie, PDO::PARAM_STR);
		$this->pdoExec($rows,__FUNCTION__);

		$studentRow=$rows->fetchAll(PDO::FETCH_ASSOC);
		
		if ($studentRow!=NULL) {
			$student=array();
			$student=$studentRow[0];
			return $student;
		}
		else{
			return false;
		}
	}
	
	
	
	/*Проверка на существование e-mail'а
	* true - уже есть такой email
	* false - нет
	*/
	private function checkEmail($email){
		$rows = $this->db->prepare("SELECT * FROM `students` WHERE `email`=:email");
		$rows->bindValue(':email', $email, PDO::PARAM_STR);
		$this->pdoExec($rows,__FUNCTION__);

		$studentRow=$rows->fetchAll(PDO::FETCH_ASSOC);	

		if( (count($studentRow)) > 0){
			$status=true;
		}
		else{
			$status=false;
		}

		return $status;
	}	
	
	
	
	
	
	//Добавляет новую строку в БД
	public function addStudent(Student $student){		
		//Проверяет, а нет ли  в базе такого e-mail'а
		$alredyRegistered=$this->checkEmail($student->email);
		if($alredyRegistered){
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
	

	}
	
		
	public function editStudent(Student $student){


		//Исключение совпадения e-mail'ов разных юзеров
		$currentStudentData=$this->getStudentByHash($student->hash);
		$currentEmail=$currentStudentData['email'];

		if ($currentEmail!=$student->email){ //Если юзер пытается изменить текущий e-mail
			$alredyRegistered=$this->checkEmail($student->email);
		}

		if ($alredyRegistered) { //Если юзер меняет свой e-mail на e-mail другого юзера
			$this->userErrors[]='Такой e-mail уже зарегистрирован';
			return;
		}
		else{


			$rows = $this->db->prepare("UPDATE `students` SET `name`=:name,`sname`=:sname,`group_num`=:group_num,`points`=:points,`gender`=:gender,`email`=:email,`b_year`=:b_year,`is_resident`=:is_resident WHERE `hash`=:hash");

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



		}
	}


}