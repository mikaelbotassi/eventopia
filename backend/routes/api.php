<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
