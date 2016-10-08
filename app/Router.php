<?php
namespace StudentList;
/**
 * Роутер
 * Разбирает URL
 *
**/
class Router
{
    protected $isUriValid;
    protected $action;
    protected $controllersList;
    protected $projectFolder;
    
    function __construct($controllersList,$projectFolder,$url){
    /**
     * Делаем валидацию введённого адреса
     */
    //Если пользователь обращается к "site.ru/path/to/public", то браузер автоматически дописывает "/" в конце, а если site.ru/path/to/public/action, то не дописывает.
    // Со знаком "/" на конце и без parse_url будет работать по разному
    // Поэтому мы его удаляем
    //Так же предотвращает пользовательскую ошибку "site.ru/path/to/public/action/"
        $url=trim($url,'/');
    //Игнорируем наличие слеша в конфиге
        $projectFolder=trim($projectFolder,'/');
    //Разбиваем ссылку на части, выкидывая переменные
        $parsedUrl=parse_url(trim($url,'/'));
        $explodedUrl=explode('/', $parsedUrl['path']);
    //Выбираем из ссылки всё, кроме экшена (а экшен у нас обязятельно односложный). То есть берём всё, кроме последнего элемента. Получаем "путь к папке public"
        $lenght=count($explodedUrl)-1;
        $urlForRoot=array_slice($explodedUrl, 0,$lenght);
        $urlForRoot=implode('/', $urlForRoot);
    //Сравниваем
        //Пользователь вводит какую-то дичь
        //students.ru/path/to/public/kakaya/to/dich/register
        if ($urlForRoot!=$projectFolder) {
            $this->isUriValid=false;
        }
        else{
            $this->isUriValid=true;
            $this->controllersList=$controllersList;
            $this->projectFolder=$projectFolder;
            $this->action=array_pop($explodedUrl);
            
            //Переданная пользователем ссылка без переменных
            $implodedUrl=$parsedUrl['path'];
            //Если экшн в ссылке не указан, значит пользователь заходит на главную
            if ($implodedUrl==$projectFolder) {
                $this->action='main';
            }
        }

    }
    
    public function getAction(){
        return $this->action;
    }

    public function makeUrl($path){
        return $path;
        /*$root=$this->projectFolder;
        return (($root=='/') ? '' : $root)  .'/'.$path;*/
    }

    public function isUriValid(){
        return $this->isUriValid;
    }

    public function getControllerName(){
        $action=$this->getAction();
        if (array_key_exists($action, $this->controllersList)) {
            return $this->controllersList[$action];
        }
        else{
            return NULL;
        }
    }
}