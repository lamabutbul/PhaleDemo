<?php

require('bower_components/Dephendency/index.php');

use Phale\App;
use Phale\Request;
use Phale\Response;

require_once('user/api.php');

$app = new App('demo', '/PhaleDemo');

$app->factory('config', [], function(){
    return json_decode(file_get_contents('config.json'));
});

$app->factory('database', ['config'], function(Config $config){
    return new Database(
        $config->get('db.host', 'localhost'),
        $config->get('db.username'),
        $config->get('db.password'),
        $config->get('db.database'),
        $config->get('db.port', 3306),
        $config->get('db.charset', 'utf-8')
    );
});

$app->get('/', [], function(Request $request, Response $response){

});

$app->module('/user', $users);

$request = Request::fromHttp($_SERVER);
$response = Response::fromHttp();

$app->run($request, $response);
