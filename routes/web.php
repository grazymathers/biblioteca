<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivrosController;

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
Route::get('/registro', function () {
    return view('auth.register');
  })->name('registro');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('acesso');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/registro', [AuthController::class, 'register'])->name('register');
Route::get('/books/listar', [LivrosController::class, 'index'])->name('listarLivros');

