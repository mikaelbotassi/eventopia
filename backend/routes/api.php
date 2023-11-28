<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CertificateController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'version' => app()->version()
    ]);
});

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::controller(AuthController::class)->group(function (){
        Route::post('login', 'login');
        Route::get('logout', 'logout');
        Route::get('refresh', 'refresh');
        Route::get('me', 'me');
    });

});

Route::group([

    'prefix' => 'user',

], function ($router) {

    Route::controller(UserController::class)->group(function (){
        Route::middleware('auth:api')->group(function (){
            Route::put('', 'update');
            Route::get('me', 'me');
        });
        Route::post('', 'create');
        Route::get('/{id}', 'findById');
        Route::delete('', 'delete');
    });

});

Route::group([

    'prefix' => 'category',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(CategoryController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});

Route::group([

    'prefix' => 'feedback',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(FeedbackController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});

Route::group([

    'prefix' => 'event',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(EventController::class)->group(function (){
        Route::post('', 'create');
        Route::post('/filter', 'getAllWithFilter');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});

Route::group([

    'prefix' => 'registration',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(RegistrationController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
        Route::get('qr-code/{event_id}', 'getQrCode');
        Route::get('confirm-presence/{qrCode}', 'confirmPresence');
    });

});

Route::group([

    'prefix' => 'certificate',
    'middleware' => 'auth:api'

], function ($router) {

    Route::controller(CertificateController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});
