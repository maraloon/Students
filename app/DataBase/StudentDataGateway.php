<?php
namespace StudentList\DataBase;
use \StudentList\Models\Student;

class StudentDataGateway{
    protected $db; //Объект PDO

    function __construct(\PDO $connection){
        $this->db=$connection;
    }

    /**
     * Кол-во записей в таблице
     * 
     * Если $find=NULL
     *    Вернуть кол-во всех строк таблицы
     * Иначе
     *    Вернуть кол-во строк, в которых есть вхождение $find
     */
    public function countStudents($find=NULL){
        //Если задан поиск по строке $find
        if (isset($find)) {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) FROM `students`
                WHERE CONCAT(`name`,' ',`sname`,' ',`group_num`,' ',`points`)
                LIKE :search");
            $find = addCslashes($find, '\%_'); // http://phpfaq.ru/mysql/slashes#like
            $find='%'.$find.'%';
            $stmt->bindValue(':search', $find, \PDO::PARAM_STR);
        }
        else{
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `students`");
        }
        
        $stmt->execute();
        $count=$stmt->fetchColumn();
        return $count;
    }    
    
    
    private function getColumns(){
        $stmt = $this->db->prepare("SHOW COLUMNS FROM `students`");
        $stmt->execute();
        $columns=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        $columns = array_column($columns, 'Field');

        return $columns;
    }
    
    /**
     * Возвращает массив, где каждый studentsRows - объект Student
     * $limit записей, начиная с $offset
     */
    public function getStudents($sortBy,$orderBy,$limit,$offset,$find=NULL){
        if( (!in_array($sortBy, $this->getColumns()))
            or ($sortBy=='hash') )  //запрещаем сортировать по hash
        {
            $sortBy='points';
        }
        $orderBy= $orderBy=='asc'? 'asc' : 'desc'; //если передаётся шняга, то desc
        
        //Если задан поиск по строке $find
        if (!is_null($find)) {
            $stmt = $this->db->prepare("
                SELECT * FROM `students`
                WHERE CONCAT(`name`,' ',`sname`,' ',`group_num`,' ',`points`)
                LIKE :search
                ORDER BY $sortBy $orderBy
                LIMIT :limit OFFSET :offset");
            $find = addCslashes($find, '\%_'); // http://phpfaq.ru/mysql/slashes#like
            $find='%'.$find.'%';
            $stmt->bindValue(':search', $find, \PDO::PARAM_STR);
        }
        else{
            $stmt = $this->db->prepare("
                SELECT * FROM `students`
                ORDER BY $sortBy $orderBy
                LIMIT :limit OFFSET :offset");
        }

        
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();
        
        $studentsRows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        //Подготавливаем массив
        $students=array();
        foreach($studentsRows as $studentRow){
            $student=new Student();
            $student->addInfo($studentRow);
            $students[]=$student;
        }
        return $students;
    }
    
    /**
     * Принимает хеш. Возвращает объект студента
     */
    public function getStudentByHash($hash){
        $stmt = $this->db->prepare("SELECT * FROM `students` WHERE `hash`=:hash");
        $stmt->bindValue(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();

        $studentRow=$stmt->fetch(\PDO::FETCH_ASSOC);

        if ($studentRow!=NULL) {
            $student=new Student();
            $student->addInfo($studentRow);
            return $student;
        } else {
            return false;
        }
    }
    
    
    
    /**
     * Проверка на существование e-mail'а
     * 
     * Если id не указан
     *  Ищет e-mail в таблице
     * Если id указан
     *  Ищет строку с переданными id и email
     * 
     * @var string email
     * @var integer id
     * 
     * @return bool isEmailUsed
     */
    public function checkEmail($email,$id=NULL){
        if ($id) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `students` WHERE `email`=:email AND `id`<>:id");
            $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        }
        else{
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `students` WHERE `email`=:email");
        }

        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->fetchColumn();        

        return $count > 0;
    }
    
    /**
     * Добавляет нового студента в БД
     * 
     * @var Student student
     */
    public function addStudent(Student $student){
        $SqlString="INSERT INTO `students`
                    (`name`,`sname`,`group_num`,`points`,`gender`,`email`,`b_year`,`residence`,`hash`)
                    VALUES
                    (:name,:sname,:group_num,:points,:gender,:email,:b_year,:residence,:hash)";
        $this->writeToTable($SqlString,$student);
    }
    
     /**
     * Привит студента в БД
     * 
     * @var Student student
     */       
    public function editStudent(Student $student){
        $SqlString="UPDATE `students`
        SET
            `name`=:name,
            `sname`=:sname,
            `group_num`=:group_num,
            `points`=:points,
            `gender`=:gender,
            `email`=:email,
            `b_year`=:b_year,
            `residence`=:residence
        WHERE `hash`=:hash";
        $this->writeToTable($SqlString,$student);

    }

    /**
     * Запись изменений в БД
     */
    protected function writeToTable($SqlString,$student){
        $stmt = $this->db->prepare($SqlString);

        $stmt->bindValue(':name', $student->name, \PDO::PARAM_STR);
        $stmt->bindValue(':sname', $student->sname, \PDO::PARAM_STR);
        $stmt->bindValue(':group_num', $student->group_num, \PDO::PARAM_STR);
        $stmt->bindValue(':points', $student->points, \PDO::PARAM_INT);
        $stmt->bindValue(':gender', $student->gender, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $student->email, \PDO::PARAM_STR);
        $stmt->bindValue(':b_year', $student->b_year, \PDO::PARAM_INT);
        $stmt->bindValue(':residence', $student->residence, \PDO::PARAM_STR);
        $stmt->bindValue(':hash', $student->hash, \PDO::PARAM_STR);
        $stmt->execute();
    }

}