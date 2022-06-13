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



Route::get('dev', [\App\Http\Controllers\DevController::class, 'dev']);
Route::get('/{page}', \App\Http\Controllers\MainController::class)->where('page', '.*');
Auth::routes();
