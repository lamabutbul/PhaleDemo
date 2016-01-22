<?php

use Phale\Module;
use Phale\Request;
use Phale\Response;
use PhaleDemo\User\IUserService;
use PhaleDemo\User\UserNotFoundException;


$user = new Module('user');

/**
 * @api {get} /user/:id Get
 * @apiName GetUser
 * @apiGroup User
 * @apiVersion 1.0.0
 *
 * @apiParam (URL Parameters) {Integer} id The user id.
 *
 * @apiParamExample Request Example
 * GET /user/1
 *
 * @apiSuccess {Integer} id The user id.
 * @apiSuccess {String} username The login username.
 * @apiSuccess {String} password The login password.
 * @apiSuccess {String} email The user email address.
 * @apiSuccess {String} notes Notes about the user record.
 * @apiSuccess {Boolean} deleted Whether the user record is deleted.
 * @apiSuccess {Timestamp} created_at When the user was created.
 * @apiSuccess {Timestamp} updated_at When the user was last updated.
 *
 * @apiSuccessExample {json} Response Example
 * HTTP/1.1 200 OK
 * {
 *     "id": 1,
 *     "username": "lamabutbul",
 *     "password": "lamabutbul",
 *     "email": "lamabutbul@PhaleDemo.git",
 *     "notes": "",
 *     "deleted": false,
 *     "created_at": "2016-01-22 00:24:08",
 *     "updated_at": "2016-01-22 00:24:08"
 * }
 *
 * @apiError (Error 404) UserNotFoundError When the user id isn't found.
 *
 * @apiErrorExample Error Response Example
 * HTTP/1.1 404 Not Found
 * {
 *     "error": "UserNotFoundError"
 *     "reason: "The user id was not found."
 * }
 */
$user->get('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){
    try {
        $response->json($userService->find($id));
    }
    catch (UserNotFoundException $e) {
        $response->status = 404;
        $response->json([
            'error' => 'UserNotFoundError',
            'reason' => 'The user id was not found.',
        ]);
    }
});

$user->put('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});

$user->delete('', ['userService'], function(Request $request, Response $response, $id, IUserService $userService){

});
