<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\vistasController;

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

Route::middleware('guest')->group(function() {
    Route::get('/login', [vistasController::class, 'loginView'])->name('login.show');
    Route::get('/register', [vistasController::class, 'registerView']);
    Route::get('/verify/{id}', [vistasController::class, 'verifyView'])->name('verify.show')->middleware('signed');
    Route::get('/verifysession/{id}', [vistasController::class, 'verifysessionView'])->name('verifysession.show')->middleware('signed');
    Route::post('/register', [userController::class, 'register'])->name('register');
    Route::post('/verifycode/{id}', [userController::class, 'verifycode'])->name('verifycode');
    Route::post('/verifysession/{id}', [userController::class, 'verifysession'])->name('verifysession');
    Route::post('/login', [userController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function() {
    Route::get('/inicio', [vistasController::class, 'inicioView'])->name('inicio.show');
    Route::post('/logout', [userController::class, 'logout'])->name('logout');
});





Route::get('/', function () {
    return redirect()->route('login.show');
});
