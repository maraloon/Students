<?php
//DI container
$container = new Pimple\Container;

//
$container['json']=function ($c) {
    return new JSONLoader();
};

$container['config']=function ($c) {
    return $c['json']->getConfig();
};

$container['routerFile']=function ($c) {
    return $c['json']->getRouter();
};

$container['router']=function ($c) {
    return new Router($c);
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

$container['table']=function ($c) {
    return new StudentDataGateway($c['db']);
};

$container['auth']=function ($c) {
    return new Authorization($c);
};