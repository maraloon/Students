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
    return new DataBase($c['config']['db']);
};

$container['table']=function ($c) {
    return new StudentDataGateway($c['db']->connection());
};

$container['auth']=function ($c) {
    return new Authorization($c);
};