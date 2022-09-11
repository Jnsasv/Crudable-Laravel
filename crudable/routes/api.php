<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('validate-code', [ApiAuthController::class, 'validateCode']);
Route::get('checkroles', [UserController::class, 'checkRoles']);
Route::post('forgot-password', [ApiAuthController::class, 'forgotPassword'])
    ->name('password.email');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('resend-code', [ApiAuthController::class, 'resendCode']);
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::post('checktoken', [ApiAuthController::class, 'checktoken']);

    Route::group(['middleware' => ['verified']], function () {
        Route::get('get-user-info', [UserController::class,'getUserInfo']);
        Route::post('post-user-info', [UserController::class,'postUserInfo']);

        Route::prefix('crud')->name('crud.')->controller(CrudController::class)->group(function(){
            Route::get('{model}/','index')->name('index');
            Route::get('{model}/create','create');
            Route::get('{model}/edit/{id}','edit');
            Route::put('{model}/update','update');
            Route::post('{model}/store','store');
            Route::get('{model}/delete/{id}','delete');
            Route::delete('{model}/destroy','destroy');
            Route::get('{model}/reactivate/{id}','reactivate');
            Route::post('{model}/activate','activate');
        });
    });
});

