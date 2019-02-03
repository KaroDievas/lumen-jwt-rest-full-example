<?php

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
use Illuminate\Http\Request;
$router->get('/', function () use ($router) {
    return $router->app->version();
});





$router->group(
    [
        'prefix' => 'api'
    ],
    function () use ($router) {

        $router->post(
            'auth/login',
            [
                'uses' => 'AuthController@authenticate'
            ]
        );

        $router->put(
            'user/password-change',
            [
                'uses' => 'UserController@changePassword'
            ]
        );

        $router->get(
            'user/password-remember',
            [
                'uses' => 'UserController@passwordRemember'
            ]
        );

        $router->group(
            [
                'prefix' => 'todo',
                'middleware' => 'auth',
            ],
            function () use ($router) {
                $router->post('create', [
                    'uses' => 'ToDoController@createToDo'
                ]);
                $router->put('update/{id}', [
                    'uses' => 'ToDoController@editToDoById'
                ]);
                $router->delete('remove/{id}', [
                    'uses' => 'ToDoController@deleteToDoById'
                ]);
                $router->get('my-todo-list', [
                    'uses' => 'ToDoController@getAllMyToDo'
                ]);
                $router->get('all-todo-list', [
                    'uses' => 'ToDoController@getAllToDo'
                ]);
            }
        );

        $router->group(
            [
                'prefix' => 'audit-log',
                'middleware' => 'auth',
            ],
            function () use ($router) {
                $router->get('get-all', [
                    'uses' => 'AuditLogController@viewAuditLog'
                ]);
            }
        );
    }
);