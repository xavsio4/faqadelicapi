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

Route::get('/', function () {
    return view('welcome');
});

//default routes response
$router->get('api', function () use ($router) { 
    //return $router->app->version();
    return "Ho hey..how are you ? You...look lost..";
    
}) -> name('api'); 
