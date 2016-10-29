<?php
namespace StudentList\Controllers;
use \StudentList\Helpers;

/**
 * Показывает таблицу студентов
 */
class MainController extends ViewController{

    public function mainAction(){
        $this->showStudentList();
        $this->showView();
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
        $studentsNum=$this->c['studentsGW']->countStudents($find); //всего студентов в базе
        $pages=ceil($studentsNum/$limit); //всего страниц

        $currentPage=isset($_GET['page']) ? max($_GET['page'],1) : 1;
        $offset=($currentPage-1)*$limit;

    //Параметры для сортировки
        $sortBy='points';
        $orderBy='asc';

        if (isset($_GET['sortBy'])) {
            if (in_array(strval($_GET['sortBy']), array('name','sname','group_num','points'))){
                $sortBy=strval($_GET['sortBy']);
            }   
        }
        if (isset($_GET['orderBy'])) {
            if (in_array(strval($_GET['orderBy']), array('asc','desc'))){
                $orderBy=strval($_GET['orderBy']);
            }
        }

    //Статус изменения данных
        $message=isset($_GET['message']) ? strval($_GET['message']) : NULL;

        $table=$this->c['studentsGW'];
        $students=$table->getStudents($sortBy,$orderBy,$limit,$offset,$find);
        //Генерация динамического контента для представления
        $urlMaker = new Helpers\TableUrlMaker($currentPage,$sortBy,$orderBy,$find,$this->action);

        //Устанавливаем другое представление, если осуществляется поиск
        if (!is_null($find)) {
            $this->viewName='search';
        }
        //Переменные, используемые в представлении
        $this->render(compact('students','urlMaker','isAuthorized','user','find','pages','currentPage','message'));
    }

}