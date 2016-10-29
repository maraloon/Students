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
     * @param Pimple\Container $container
     */
    public function __construct(\Pimple\Container $container){
        parent::__construct($container);
    }

    public function start(){
        $router=new \StudentList\Router(
                $this->c['JSONLoader']->readJSON('router.json'),
                $this->c['config']['projectFolder'],
                $_SERVER['REQUEST_URI']
            );

        $this->router=$router;

        if (!$router->isUriValid()){
            $this->errorCaller(404);
            exit;
        }

        $controllerName=$router->getControllerName();
        if ($controllerName==NULL) {
            $this->errorCaller(404);
            exit;
        }

        $controllerPath='\StudentList\Controllers\\'.$controllerName;
        $controller=new $controllerPath($this->c,$router->getAction());

        $actionFunc=$router->getAction().'Action';

        if (!method_exists($controller, $actionFunc)){
            $this->errorCaller(404);
            exit;
        }
        //Вызываем у нужного контроллера нужный экшн
        $errorCode=$controller->$actionFunc();
        if ($errorCode!=NULL) {
            $this->errorCaller($errorCode);
            exit;
        }
        //$controller->showView();
    }

    private function errorCaller($errorCode){
        $controller=new ErrorController($this->c,$this->router);
        $controller->errorAction($errorCode);
        //$controller->showView();
    }
    
}
