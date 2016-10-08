<?php
namespace StudentList\Controllers;
use StudentList\Helpers\Util;

/**
 * Front Controller
 * 
 * Вызывает нужный контроллер
 */
class FrontController extends Controller{

    /**
     * Constructor
     * 
     * @param array $container Pimple Container
     */
    function __construct($container){
        parent::__construct($container);
    }

    function Start(){
        $router=new \StudentList\Router(
                $this->c['json']->readJSON('router.json'),
                $this->c['config']['projectFolder'],
                $_SERVER['REQUEST_URI']
            );

        if (!$router->isUriValid()){
              header("Location: error?code=404");
        }

        $controllerName=$router->getControllerName();

        if ($controllerName==NULL) {
            header("Location: error?code=404");
        }

        $controllerPath='\StudentList\Controllers\\'.$controllerName;
        $controller=new $controllerPath($this->c,$router);

        $actionFunc=$router->getAction().'Action';

        if (!method_exists($controller, $actionFunc)){
            header("Location: error?code=404");
        }
        //Вызываем у нужного контроллера нужный экшн
        $errorCode=$controller->$actionFunc();
        if ($errorCode!=NULL) {
            header("Location: error?code=$errorCode");
        }
        $controller->showView();
    }
}
