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

Route::get('/', [AuthenticateUserController::class, "showLoginForm"])->middleware('auth.redirect')->name('show_LoginForm');
Route::post('/login', [AuthenticateUserController::class, "login"]);
Route::get('/logout', [AuthenticateUserController::class, 'logout'])->name('logout');
route::get('/crear-operador', [AuthenticateUserController::class, 'showRegister'])->middleware('auth')->name('showRegisterCreate');
route::post('/crear-operador', [AuthenticateUserController::class, 'saveRegistrar'])->name('saveRegistrar');



Route::get('/consulta', [VisitorController::class, 'showConsulForm'])->middleware('auth')->name('show_ConsulForm');

Route::get('/registro-de-visitantes', [VisitorController::class, 'showRegister'])->middleware('auth')->name('show_Register_Visitor');

Route::get('/registro-de-visitantes/{cedula}', [VisitorController::class, 'showRegisterDetail'])->middleware('auth')->name('show_Register_Visitor_Detail');

Route::get('/registro', [VisitorController::class, 'showRegisterVisitor'])->middleware('auth')->name('show_register');

Route::post('/consulta', [VisitorController::class, 'consulDate']);

Route::post('/guardar-registro', [VisitorController::class, 'saveVisitor'])->name('guardar_RegistroVisitor');
