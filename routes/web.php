<?php

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
    require __DIR__.'/crud.php';

    Route::post('message', function (Request $request) {
        return view('crud.message',['message'=>$request->all()]);
    });

});



require __DIR__.'/auth.php';
