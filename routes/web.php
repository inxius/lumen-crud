<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/login
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1 
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');

    // Matches "/api/update/1
    $router->put('update/{id}', 'UserController@updateUser');

    // Matches "/api/delete/1
    $router->delete('delete/{id}', 'UserController@deleteUser');

    // Matches "/api/post/{iduser}
    $router->post('post/{id}', 'UserController@addPost');

    // Matches "/api/userpost/{iduser}
    $router->get('userpost/{id}', 'UserController@userPost');

    // Matches "/api/updatepost/{idpost}
    $router->put('updatepost/{id}', 'UserController@updatePost');

    // Matches "/api/deletepost/{idpost}
    $router->delete('deletepost/{id}', 'UserController@deletePost');

    // Matches "/api/totalposts
    $router->get('totalposts', 'UserController@totalPost');

    // Matches "/api/posts
    $router->get('posts', 'UserController@allPost');
});
