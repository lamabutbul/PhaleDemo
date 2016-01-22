<?php

use Phale\Module;
use Phale\Request;
use Phale\Response;
use PhaleDemo\Database;
use PhaleDemo\User\IUserService;
use PhaleDemo\User\UserService;
use PhaleDemo\User\UserNotFoundException;

$user = new Module('user');

$user->get('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){
    try {
        $response->json($userService->find($id));
    }
    catch (UserNotFoundException $e) {
        $response->status = 404;
    }
});

$user->put('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});

$user->delete('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});


$users = new Module('users');

$users->factory('userService', ['database'], function(Database $database){
    return new UserService($database);
});

$users->get('', ['userService'], function(Request $request, Response $response, IUserService $userService){
    $response->json($userService->findAll());
});

$users->post('', ['userService'], function(Request $request, Response $response, IUserService $userService){

});

$users->module('/:id', $user);
