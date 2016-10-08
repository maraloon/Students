<?php
namespace StudentList\Controllers;
use \StudentList\Helpers;

/**
 * Показывает таблицу студентов
 */
class MainController extends ViewController{

    public function mainAction(){
        $this->showStudentList();
    }
    public function searchAction(){
        $this->showStudentList();
    }

    protected function showStudentList(){
    //Авторизован ли пользователь
        $isAuthorized=$this->c['authHelper']->checkAuth();
    //Получаем данные юзера
        $user=$isAuthorized ? $this->c['authHelper']->getUser() : NULL;

    //Параметры для поиска
        $find=isset($_GET['find']) ? strval($_GET['find']) : NULL;

    //Параметры для постраничной навигации
        $limit=10; //студентов на странице
        $studentsNum=$this->c['table']->countStudents($find); //всего студентов в базе
        $pages=ceil($studentsNum/$limit); //всего страниц

        $currentPage=isset($_GET['page']) ? max($_GET['page'],1) : 1;
        $offset=($currentPage-1)*$limit;

    //Параметры для сортировки
        $sortBy='points';
        $orderBy='asc';

        if (isset($_GET['sortBy'])) {
            if (in_array($_GET['sortBy'], array('name','sname','group_num','points'))){
                $sortBy=strval($_GET['sortBy']);
            }   
        }
        if (isset($_GET['orderBy'])) {
            if (in_array($_GET['orderBy'], array('asc','desc'))){
                $orderBy=strval($_GET['orderBy']);
            }
        }

    //Статус изменения данных
        $registerOk=isset($_GET['registerOk']) ? strval($_GET['registerOk']) : NULL;
        $editOk=isset($_GET['editOk']) ? strval($_GET['editOk']) : NULL;



        $table=$this->c['table'];
        $students=$table->getStudents($sortBy,$orderBy,$limit,$offset,$find);
        //Генерация динамического контента для представления
        $urlMaker = new Helpers\TableUrlMaker($currentPage,$sortBy,$orderBy,$find,$this->action);
        $router=$this->router;

        //Переменные, используемые в представлении
        $this->render(compact('students','urlMaker','router','isAuthorized','user','find','pages','currentPage','registerOk','editOk'));
    }

}