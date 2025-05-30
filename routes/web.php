<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SortieController;
use App\Http\Controllers\VersementController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('entrees', EntreeController::class);
    Route::resource('sorties', SortieController::class);
    Route::resource('versements', VersementController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('categories', CategoryController::class);

    // Routes admin uniquement
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
    //profile.edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

