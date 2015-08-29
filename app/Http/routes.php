<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//index page
Route::get('/', function () {
    return view('welcome');
});


//define all pages you need in frontent
Route::get('/{name}', function () {
    return view('welcome');
})->where('name', 'profile|tasks|register|login');

//register
Route::post('api/user/', 'TokenAuthController@register');

//get token
Route::post('api/user/authenticate', 'TokenAuthController@authenticate');

//get user
Route::get('api/user', 'TokenAuthController@getAuthenticatedUser');

//todos
Route::resource('api/todo', 'TodoController');
