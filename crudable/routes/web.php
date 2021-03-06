<?php

use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->middleware(['auth'])->group(function(){
    //TODO: agregar role pertinente
    Route::prefix('crud')->name('crud.') ->middleware(['auth'])->controller(CrudController::class)->group(function(){
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

    Route::post('message', function (Request $request) {
        return view('crud.message',['message'=>$request->all()]);
    });

});



require __DIR__.'/auth.php';
