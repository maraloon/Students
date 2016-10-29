<?php
namespace StudentList\Controllers;
use \StudentList\Helpers\Util;
abstract class ViewController extends Controller{
    protected $action;
    protected $viewName;
    protected $viewVars;

    function __construct(\Pimple\Container $c,$action){
        parent::__construct($c);
        $this->action=$action;
        $this->viewName=$this->action; //Если имя представления != action, это указывается в самом контроллере

    }

    public function render(array $viewVars){
        $this->viewVars=$viewVars;
    }

    public function showView($viewVars=NULL){
        if (isset($this->viewVars)) {
            extract($this->viewVars);
        }
        include(Util::getAbsolutePath('app/views/pages/index.php'));
    }
}