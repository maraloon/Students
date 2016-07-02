<?php
//DI container
$container = new Pimple\Container;

//
$container['config']=function ($c) {
    return JSONLoader::config();
};

$container['routerFile']=function ($c) {
    return JSONLoader::router();
};

$container['router']=function ($c) {
    return new Router();
};

$container['db']=function ($c) {
	$connect_str = 'mysql'
    .':host='. $c['config']['db']['host']
    .';dbname='.$c['config']['db']['dbname'];
    
    $db=new PDO($connect_str,
        $c['config']['db']['user'],
        $c['config']['db']['password']
				/*,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8, sql_mode='STRICT_ALL_TABLES'")*/
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