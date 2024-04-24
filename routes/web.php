<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateUserController;
use App\Http\Controllers\VisitorController;

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

Route::get('/', [AuthenticateUserController::class, "showLoginForm"])->name('show_LoginForm');
Route::post('/login', [AuthenticateUserController::class, "login"]);
Route::get('/logout', [AuthenticateUserController::class, 'logout'])->name('logout');

Route::get('/consulta-y-registro', [VisitorController::class, 'showConsulForm'])->middleware('auth')->name('show_ConsulForm');
Route::post('/consulta-y-registro', [VisitorController::class, 'consulDate']);


// Route::get('/formulario-de-registro', [VisitorController::class, 'showRegistrationForm'])->middleware('auth')->name('show_RegistrationForm');
