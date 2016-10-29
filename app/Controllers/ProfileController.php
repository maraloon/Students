<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;
use \StudentList\Models\Student;

/**
 * Контроллер изменения данных студента или его регистрации
 */
class ProfileController extends ViewController{

    public function registerAction(){
        if ($this->c['authHelper']->checkAuth()==true)
        {
            header("Location: main?message=access_denied");
            exit;
        }
        $this->showAction();
    }

    public function editAction(){
        if ($this->c['authHelper']->checkAuth()==false)
        {
            header("Location: main?message=access_denied");
            exit;
        }
        $this->showAction();
    }

    protected function showAction(){
        $error=$this->handleEditForm();
        if ($error!=NULL)
        {
            return $error;
        }
        return $this->showView();
    }

    protected function handleEditForm(){
        $token=Util::setCsrfToken();
        $student=$this->prepareStudentForForm();
        if (!$student) {
            return 403;
        }

        
        //Если данные формы передавались
        if(!empty($_POST)){
            //Проверка токена
            if(!Util::checkCsrfToken()){
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
        $action=$this->action;
        $this->render(compact('student','token','validErrors','action'));
        $this->viewName='profile_edit';
    }



    /**
     * Возвращает экземпляр студента, данные которого требуется изменить, либо пустой экземпляр студента
     */
    protected function prepareStudentForForm(){
        $student=new Student();
        if ($this->action=='edit') {
            $student=$this->c['studentsGW']->getStudentByHash($_COOKIE['hash']);
        }
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
     * Фильтрует поля по белому списку
     * 
     * @param array $post Данные из формы в виде ассоциативного массива
     * 
     * @return array $post
     */
    protected function filter(array $post){
        $template=array_flip(array('name','sname','group_num','points','gender','email','b_year','residence','hash'));
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
        $this->c['studentsGW']->addStudent($student);
        $this->c['authHelper']->logIn($student->hash);
        header('Location: main?message=register_succsess');
        exit;
    }

    /**
     * Изменить данные студента
     * 
     * Передает в TDG данные существующего студента
     * Перенаправляет на главную с оповещением статуса редактирования данных
     */
    protected function editStudent(Student $student){
        $edit=$this->c['studentsGW']->editStudent($student);
        header('Location: main?message=edit_succsess');
        exit;
    }

}