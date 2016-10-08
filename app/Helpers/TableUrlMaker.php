<?php
namespace StudentList\Helpers;
/**
 * Составляет ссылки сортировки в таблице
 */
class TableUrlMaker{
    public $page;
    public $sortBy;
    public $orderBy;
    public $find;
    protected $action;

    function __construct($page,$sortBy,$orderBy,$find,$action){
        $this->page=$page;
        $this->sortBy=$sortBy;
        $this->orderBy=$orderBy;
        $this->find=$find;
        $this->action=$action;
    }



    /**
    * Меняет или добавляет в текущий url значение параметров сортировки sortBy, orderBy
    * № cтраницы page сбрасывается на 1ую
    */ 
    public function makeSortUrl($row){
        $sortBy=$this->sortBy;
        $orderBy=$this->orderBy;

        if ($row==$sortBy) { //если таблица уже отсортирована по этому столбцу
            $orderBy = $orderBy=='asc' ? 'desc' : 'asc'; //изменить порядок
        }

        return $this->makeUrl(array('page' => '1','sortBy'=>$row,'orderBy'=>$orderBy));
    }

    /**
    * Меняет или добавляет в текущий url значение № страницы page
    * Страница сбрасывается на 1ую
    */ 
    public function makePageUrl($row){
        return $this->makeUrl(array('page'=>$row));
    }

    /**
     * Строит url
     * 
     * Если переменная не переопределена, то берётся из $this
     * Иначе берётся из входного параметра
     */
    private function makeUrl(Array $changedParams){
        $currentParams= array('page' => $this->page, 'sortBy' => $this->sortBy,'orderBy' => $this->orderBy,'find' => $this->find);
        $currentParams=array_diff_key($currentParams,$changedParams); //ключи что есть в $currentParams, но нет в $params
        
        $url=$this->action."?".http_build_query(array_merge($currentParams,$changedParams));
        return $url;
    }

    public function showSortOrder($row){
        if ($row==$this->sortBy) {
            return $this->orderBy=='asc' ? '▲' : '▼';
        }
        else{
            return false;
        }
    }

}