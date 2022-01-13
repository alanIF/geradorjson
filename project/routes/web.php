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
Route::group(['middleware' => 'web'], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    
    Auth::routes();
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/base',  [App\Http\Controllers\BaseController::class, 'index']);
    Route::get('/base/new',  [App\Http\Controllers\BaseController::class, 'new']);
    Route::post('/base/add',  [App\Http\Controllers\BaseController::class, 'add']);
    Route::post('/base/update/{id}',  [App\Http\Controllers\BaseController::class, 'update']);
    Route::get('/base/{id}/edit',  [App\Http\Controllers\BaseController::class, 'edit']);
    Route::delete('/base/delete/{id}',  [App\Http\Controllers\BaseController::class, 'delete']);
    Route::get('/base/{id}/gerar_json',  [App\Http\Controllers\BaseController::class, 'gerar_json']);
    Route::get('/base/{id}/gerar_csv',  [App\Http\Controllers\BaseController::class, 'gerar_csv']);
    Route::get('/base/{id}/gerar_sql',  [App\Http\Controllers\BaseController::class, 'gerar_sql']);

    
});