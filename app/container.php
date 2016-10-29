<?php
/**
 * Контейнер, использующий технологию Dependency Injection
 * 
 * Позволяет избежать создания копий уже созданных объектов определённого класса
 * 
 * @link http://pimple.sensiolabs.org/
 */
use StudentList\Authorization;
use StudentList\Helpers\JSONLoader;
use StudentList\DataBase\StudentDataGateway;
use StudentList\Validators\StudentValidator;

$container = new Pimple\Container;


$container['JSONLoader']=function ($c) {
    return new JSONLoader();
};

$container['config']=function ($c) {
    return $c['JSONLoader']->readJSON('config.json');
};

$container['db']=function ($c) {
    $connect_str = 'mysql'
    .':host='. $c['config']['db']['host']
    .';dbname='.$c['config']['db']['dbname'];
    
    $db=new PDO($connect_str,
        $c['config']['db']['user'],
        $c['config']['db']['password']
                ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8, sql_mode='STRICT_ALL_TABLES'")
                );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
};

$container['studentsGW']=function ($c) {
    return new StudentDataGateway($c['db']);
};

$container['authHelper']=function ($c) {
    return new Authorization($c['studentsGW']);
};

$container['validator']=function ($c) {
    return new StudentValidator($c['studentsGW']);
};