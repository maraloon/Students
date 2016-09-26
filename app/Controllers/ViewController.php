<?php
namespace StudentList\Controllers;
use \StudentList\Helpers\Util;
abstract class ViewController extends Controller{
    protected $action;
    protected $viewName;
    protected $router;
    protected $viewVars;

    function __construct($c,$router){
        parent::__construct($c);
        $this->action=$router->getAction();
        $this->viewName=$this->action; //Если имя представления != action, это указывается в самом контроллере
        $this->router=$router;

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