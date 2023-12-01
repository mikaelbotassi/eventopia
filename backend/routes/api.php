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

], function () {

    Route::controller(AuthController::class)->group(function (){
        Route::post('login', 'login');
        Route::post('/validate-password', 'validatePassword');
        Route::get('logout', 'logout');
        Route::get('refresh', 'refresh');
        Route::get('me', 'me');
    });

});

Route::group([

    'prefix' => 'user',

], function () {

    Route::controller(UserController::class)->group(function (){
        Route::middleware('auth:api')->group(function (){
            Route::put('', 'update');
            Route::get('me', 'me');
            Route::get('/{id}', 'findById');
            Route::delete('', 'delete');
        });
        Route::post('', 'create');
    });

});

Route::group([

    'prefix' => 'category',

], function () {

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

], function () {

    Route::controller(FeedbackController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::post('/filter', 'getAllWithFilter');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});

Route::group([

    'prefix' => 'event'

], function () {

    Route::controller(EventController::class)->group(function (){
        Route::middleware('auth:api')->group(function (){
            Route::post('', 'create');
            Route::post('/filter', 'getAllWithFilter');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
            Route::get('/{id}', 'getById');

        });
        Route::get('', 'getAll');
    });

});

Route::group([

    'prefix' => 'registration',
    'middleware' => 'auth:api'

], function () {

    Route::controller(RegistrationController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::post('/csv/{event_id}','getCSVByEvent');
        Route::get('/auth', 'getAllByAuthId');
        Route::get('/{id}', 'getById');
        Route::post('/filter', 'getAllWithFilter');
        Route::get('', 'getAll');
        Route::get('qr-code/{registration_id}', 'getQrCode');
        Route::get('confirm-presence/{qrCode}', 'confirmPresence');
    });

});

Route::group([

    'prefix' => 'certificate',
    'middleware' => 'auth:api'

], function () {

    Route::controller(CertificateController::class)->group(function (){
        Route::post('', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/{id}', 'getById');
        Route::get('', 'getAll');
    });

});
