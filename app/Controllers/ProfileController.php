<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;
use \StudentList\Models\Student;

/**
 * Edit/RegistProfileController
 * 
 * Контроллер изменения данных студента или его регистрации
 */
class ProfileController extends ViewController{

    public function registerAction(){
        if ($this->c['authHelper']->checkAuth()==false) {
            return $this->handleEditForm();
        }
        return 403;
    }

    public function editAction(){
        if ($this->c['authHelper']->checkAuth()==true) {
            return $this->handleEditForm();
        }
        return 403;
    }

    protected function handleEditForm(){
        $token=Util::setToken();
        $student=$this->prepareStudentForForm();
        if (!$student) {
            return 403;
        }

        
        //Если данные формы передавались
        if(!empty($_POST)){
            //Проверка токена
            if(!Util::checkToken()){
                return 400; //Попытка взлома
            }
            else{
                $student=$this->fillStudent($student);
                //Ищем ошибки в заполнении
                $validErrors=$this->c['validator']->validate($student);
                //Если нет ошибок
                if(empty($validErrors)){
                    
                    if ($this->action=='edit') {
                        $this->editStudent($student);
                    }
                    elseif($this->action=='register'){
                        $this->addStudent($student);
                    }
                }
            }
        }
        //Переменные, используемые в представлении
        $router=$this->router;
        $action=$this->action;
        $this->render(compact('student','token','validErrors','router','action'));
        $this->viewName='profile_edit';
    }



    /**
     * Возвращает экземпляр студента, данные которого требуется изменить, либо пустой экземпляр студента
     */
    protected function prepareStudentForForm(){
        $student=new Student();
        if ($this->action=='edit') {
            $student=$this->c['table']->getStudentByHash($_COOKIE['hash']);
        }
        /*if (!$student) {
            return 403;
        }*/
        return $student;
    }

    //Заполнить объект студента переданными данными
    protected function fillStudent(Student $student){
        $studentData=$this->filter($_POST);
        foreach ($studentData as $field) {
            $field=trim(strval($field));
        }

        $student->addInfo($studentData);

        if($this->action=='register'){
            $student->hash=Util::randHash();
        }
        return $student;
    }

    /**
     * Фильтрация передаваеммых пользователем данных от нежелательных переменных
     * 
     * Удаляет всё, что не 'name','sname','group_num','points','gender','email','b_year','is_resident','hash'
     * 
     * @param array $post Глобальная переменная $_POST
     * 
     * @return array $post
     */
    protected function filter(array $post){
        $template=array_flip(array('name','sname','group_num','points','gender','email','b_year','is_resident','hash'));
        $infoArray=array_intersect_key($template,$post);
        return $post;
    }

    /**
     * Добавить нового студента
     * 
     * Передает в TDG данные нового студента
     * Авторизовывает
     * Перенаправляет на главную с оповещением статуса регистрации
     */
    protected function addStudent(Student $student){
        $this->c['table']->addStudent($student);
        $this->c['authHelper']->logIn($student->hash);
        header('Location: main?registerOk');    
    }

    /**
     * Изменить данные студента
     * 
     * Передает в TDG данные существующего студента
     * Перенаправляет на главную с оповещением статуса редактирования данных
     */
    protected function editStudent(Student $student){
        $edit=$this->c['table']->editStudent($student);
        header('Location: main?editOk');
    }

}