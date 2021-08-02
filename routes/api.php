<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\FaqController;
use App\Http\Controllers\api\v1\GroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//default routes response
$router->get('/', function () use ($router) { 
    //return $router->app->version();
    return "Ho hey..how are you ? You...look lost..";
    
});

$router->get('v1/', function () use ($router) {
    //return $router->app->version();
    return "Ho hey..how are you ? You...look lost..";
    
});

// unprotected routes
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
 
 Route::group(['middleware' => 'auth:api'], function(){
	Route::get('user', [UserController::class, 'userDetails']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('/faq', [FaqController::class, 'index']);
    Route::post('/faqgrouplist', [FaqController::class, 'faqgrouplist']);
    Route::post('/addfaq',[FaqController::class,'addFaq']);
    Route::delete('/delfaq/{id}',[FaqController::class,'delFaq']);
    Route::put('/editfaq/{id}',[FaqController::class,'editFaq']);
    Route::get('/faqgroup', [GroupController::class, 'index']);
    Route::post('/faqlist', [GroupController::class, 'faqlist']);
    Route::post('/addgroup',[GroupController::class,'addGroup']);
    Route::delete('/delgroup/{id}',[GroupController::class,'delGroup']);
    Route::put('/editgroup/{id}',[GroupController::class,'editGroup']);
}); 

Route::get('/faqsbykey/{key}',[GroupController::class,'faqByKey']);

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
