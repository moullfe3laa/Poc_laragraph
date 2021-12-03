<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {return view('welcome');});

Route::get('graph', 'App\Http\Controllers\ApiController@getMailData');
Route::get('graph1', 'App\Http\Controllers\ApiController@getUsers');
Route::get('graph2', 'App\Http\Controllers\ApiController@getEmails');
Route::get('layout',  function(){
    return view('layout');
});


