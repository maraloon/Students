<?php
namespace StudentList;
use StudentList\Exceptions\AuthException;
/*
* $this->checkAuth();
* Если вернёт true, то c['authHelper']->user содержит данные авторизованного студента для представления
* Которые можно получить из getUser
*/
class Authorization{

    protected $user;
    protected $table;
    protected $isAuthorized=NULL;

    function __construct(DataBase\StudentDataGateway $table){
        $this->table=$table;
    }
    /**
     * Возвращает статус пользователя
     * Устанавливает значения полей, если авторизован
     */
    public function checkAuth(){

        $this->isAuthorized=false;
        if (isset($_COOKIE['hash'])) {
            $student=$this->table->getStudentByHash($_COOKIE['hash']);
            if ($student!=false){
                $this->isAuthorized=true;
                //Переменные для отображения
                $this->user=$student;
            }
        }
        return $this->isAuthorized;
    }

    public function logIn($hash){
        setcookie('hash',$hash,time()+3600*12*365,'/',null,false,true);
    }

    //не используется в коде
    public function logOut(){
        setcookie('hash','',time()-3600);
    }

    public function getUser(){
        if ($this->isAuthorized) {
            return $this->user;
        }
        else{
            throw new AuthException('Попытка гостя получить данные авторизованного пользователя');
        }
    }
}