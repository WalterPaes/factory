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
    return response()->json([], 404);
});

$router->post('/api/login', 'AuthController@login');

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('', 'UserController@index');
        $router->post('', 'UserController@store');
        $router->get('{id}', 'UserController@show');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');

        $router->get('{id}/maintenances', 'MaintenanceController@searchByuser');
    });

    $router->group(['prefix' => 'equipments'], function () use ($router) {
        $router->get('', 'EquipmentController@index');
        $router->post('', 'EquipmentController@store');
        $router->get('{id}', 'EquipmentController@show');
        $router->put('{id}', 'EquipmentController@update');
        $router->delete('{id}', 'EquipmentController@destroy');

        $router->get('{id}/components', 'EquipmentController@components');
        $router->post('{id}/components', 'EquipmentController@storeEquipmentComponent');
        $router->get('{id}/maintenances', 'MaintenanceController@searchByEquipment');
    });

    $router->group(['prefix' => 'maintenances'], function () use ($router) {
        $router->get('', 'MaintenanceController@index');
        $router->post('', 'MaintenanceController@store');
        $router->get('{id}', 'MaintenanceController@show');
        $router->put('{id}', 'MaintenanceController@update');
        $router->delete('{id}', 'MaintenanceController@destroy');
    });

    $router->group(['prefix' => 'components'], function () use ($router) {
        $router->get('', 'ComponentController@index');
        $router->post('', 'ComponentController@store');
        $router->get('{id}', 'ComponentController@show');
        $router->put('{id}', 'ComponentController@update');
        $router->delete('{id}', 'ComponentController@destroy');
    });
});
