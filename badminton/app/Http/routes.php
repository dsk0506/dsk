<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' =>[ 'web','auth']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/login', 'Auth\\AuthController@login');
    Route::post('/loginDo', 'Auth\\AuthController@loginDo');
    Route::get('/register', 'Auth\\AuthController@register');
    Route::post('/registerDo', 'Auth\\AuthController@registerDo');
    Route::get('/logout', 'Auth\\AuthController@logout');
    Route::get('/send', 'Active\\IndexController@send');
    Route::post('/sendDo', 'Active\\IndexController@sendDo');
    Route::post('/signDo', 'Active\\IndexController@signDo');
    Route::get('/success/{active_id}', 'Active\\IndexController@success');
    Route::get('/sign/{active_id}', 'Active\\IndexController@sign');
    Route::get('/my', 'Active\\IndexController@my');
    Route::get('/manage/{active_id}', 'Active\\IndexController@manage');
    Route::get('/distribution/{active_id}/{active_type}', 'Active\\IndexController@distribution');
    Route::get('/enter/{active_id}/{group_name}/{group_uid}', 'Active\\IndexController@enter');
    Route::post('/enterDo', 'Active\\IndexController@enterDo');
    Route::get('/rank/{active_id}', 'Active\\IndexController@rank');
});
