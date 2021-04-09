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

Route::get('/', function () {
    return view('welcome');
});

//this is going to create required routes for Authentication process via laravel/ui package
//setting not required routes to false with array_fill_keys
//@link https://github.com/laravel/ui/blob/3.x/src/AuthRouteMethods.php
Auth::routes(array_fill_keys(['reset','confirm','verify'], false));

//route for user`s home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//routes for file resources
Route::resource('file', App\Http\Controllers\FileController::class)
    ->except(['show','edit','update'])
    ->middleware('auth');

//file.show route has get seprated from other routes to get acceable without authentication
Route::get('file/{file}', [App\Http\Controllers\FileController::class,'show'])->name('file.show');
Route::get('file/{file}/download', [App\Http\Controllers\FileController::class,'download'])
    ->name('file.download');
