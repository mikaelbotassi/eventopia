<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function (Request $request) {
    return response()->json([
        'version' => app()->version()
    ]);
});

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::controller(AuthController::class)->group(function (){
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::get('logout', 'logout');
        Route::get('refresh', 'refresh');
        Route::get('me', 'me');
    });

});

Route::group([

    'prefix' => 'user',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(UserController::class)->group(function (){
        Route::put('', 'update');
    });

});

Route::group([

    'prefix' => 'category',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(CategoryController::class)->group(function (){
        Route::post('', 'create');
        Route::get('', 'getAll');
    });

});
