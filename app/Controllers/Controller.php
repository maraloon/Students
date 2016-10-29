<?php
namespace StudentList\Controllers;
abstract class Controller{

    protected $c; //контейнер


    function __construct(\Pimple\Container $container){
        $this->c=$container;
    }

}