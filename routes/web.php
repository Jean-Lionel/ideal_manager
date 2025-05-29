<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::resource('entrees', App\Http\Controllers\EntreeController::class);

Route::resource('sorties', App\Http\Controllers\SortieController::class);

Route::resource('versements', App\Http\Controllers\VersementController::class);

Route::resource('paiements', App\Http\Controllers\PaiementController::class);
