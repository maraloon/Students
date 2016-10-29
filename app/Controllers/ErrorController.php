<?php
namespace StudentList\Controllers;

/**
 * Показывает страницу HTTP-ошибки
 */
class ErrorController extends ViewController
{

    public function errorAction($code=NULL)
    {
        //$errorCode=isset($_GET['code']) ? strval($_GET['code']) : 404;
        //Если есть перехватывающая $code, то она приоритетней $_GET['code']
        //$errorCode=isset($code) ? $code : 404;

        //Если есть перехватывающая $code, то она приоритетней $_GET['code']
        if (isset($code))
        {
            $errorCode=$code;
        }
        elseif(isset($_GET['code']))
        {
            $errorCode=strval($_GET['code']);
        }
        else
        {
            $errorCode=404;
        }
        $this->viewName='http_error';

        $this->render(compact('errorCode'));
        $this->showView();
    }

}