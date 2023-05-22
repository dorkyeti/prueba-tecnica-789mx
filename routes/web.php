<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    LoginController,
    LogOutController,
    RegisterController,
    ToDosController,
    UsersController
};

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

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginController::class)->name('login');
    Route::post('/login', [LoginController::class, 'action']);
    Route::get('/register', RegisterController::class)->name('register');
    Route::post('/register', [RegisterController::class, 'action']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', HomeController::class);
    Route::get('/home', HomeController::class)->name('home');
    Route::get('/todos', ToDosController::class)->name('todos');
    Route::get('/users', UsersController::class)->name('users');

    Route::get('/logout', LogOutController::class)->name('logout');
});
