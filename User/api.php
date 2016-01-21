<?php

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
