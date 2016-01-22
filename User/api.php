<?php

use Phale\Module;
use Phale\Request;
use Phale\Response;
use PhaleDemo\Database;
use PhaleDemo\User\IUserService;
use PhaleDemo\User\UserService;


$users = new Module('users');

$users->factory('userService', ['database'], function(Database $database){
    return new UserService($database);
});


/**
 * @api {get} /user List
 * @apiName ListUsers
 * @apiGroup User
 */
$users->get('', ['userService'], function(Request $request, Response $response, IUserService $userService){
    $response->json($userService->findAll());
});

$users->post('', ['userService'], function(Request $request, Response $response, IUserService $userService){

});

require_once('user.api.php');
$users->module('/:id', $user);
