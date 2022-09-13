<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

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
