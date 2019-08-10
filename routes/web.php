<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\ServerHandler;

Route::get('/', "MainController@index");
Route::get('/login', 'LoginController@login');
Route::post('/login/callback', 'LoginController@callback');

Route::get('/user/{id}', 'MainController@profile');

Route::post('/vk/handler', function() {
    $handler = new ServerHandler();
    $data = json_decode(file_get_contents('php://input'));
    $handler->parse($data);
});

Route::get('/test', function() {

});
