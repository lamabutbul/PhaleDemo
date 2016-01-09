<?php

use Phale\App;
use Phale\Module;
use Phale\Request;
use Phale\Response;


$user = new Module('user');

$user->get('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});

$user->put('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});

$user->delete('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});


$users = new Module('users');

$users->factory('userService', ['database'], function(IDatabase $database){
    return new UserService($database);
});

$users->get('', ['userService'], function(Request $request, Response $response, IUserService $userService){

});

$users->post('', ['userService'], function(Request $request, Response $response, IUserService $userService){

});

$users->module('/:id', $user);


$app = new App('demo');

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

$app->get('', [], function(Request $request, Response $response){

});

$app->module('/user', $users);

$app->run();
