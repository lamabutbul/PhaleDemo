<?php

require('../../bower_components/Dephendency/index.php');

use Phale\App;
use Phale\Request;
use Phale\Response;
use PhaleDemo\Database;

require_once('../../user/api.php');

$app = new App('demo', '/PhaleDemo/api/v1.0');

$app->factory('config', [], function(){
    return json_decode(file_get_contents('../../config.json'));
});

$app->factory('database', ['config'], function(stdClass $config){
    return new Database(
        $config->db->host,
        $config->db->username,
        $config->db->password,
        $config->db->database,
        $config->db->port,
        $config->db->charset
    );
});

$app->get('/', [], function(Request $request, Response $response){

});

$app->module('/user', $users);

$request = Request::fromHttp($_SERVER);
$response = Response::fromHttp();

$app->run($request, $response);

$response->respond();
