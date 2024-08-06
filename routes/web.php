<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateUserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\GerenciaController;

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

Route::get('/', [AuthenticateUserController::class, "showLoginForm"])->middleware('auth.redirect')->name('login');
Route::post('/login', [AuthenticateUserController::class, "login"]);
Route::get('/logout', [AuthenticateUserController::class, 'logout'])->name('logout');
route::get('/operador', [AuthenticateUserController::class, 'showRegister'])->middleware(['auth', 'role:administrador'])->name('showRegisterCreate');
route::post('/operador', [AuthenticateUserController::class, 'saveRegistrar'])->middleware(['auth', 'role:administrador'])->name('create_operator');
route::get('/operador/historial/{id}', [AuthenticateUserController::class, 'showHistory'])->middleware(['auth', 'role:administrador'])->name('history_Operator');
Route::post('/operador/desactivar/{id}', [AuthenticateUserController::class, 'deactivateOperator'])
    ->middleware(['auth', 'role:administrador'])
    ->name('deactivate_Operator');

Route::get('/mostrar-cambiar-contraseña', [AuthenticateUserController::class, "showChangePassword"])->middleware('auth')->name('changePassword');

Route::post('/cambiar-contraseña', [AuthenticateUserController::class, 'changePassword']);

Route::get('/consulta', [VisitorController::class, 'showConsulForm'])->middleware(['auth', 'role:operador'])->name('show_consult');
Route::post('/consulta', [VisitorController::class, 'consulDate']);

Route::get('/registro-de-visitantes', [VisitorController::class, 'showRegister'])->middleware(['auth', 'role:administrador'])->name('show_Register_Visitor');

Route::get('/registro-de-visitantes/{cedula}', [VisitorController::class, 'showRegisterDetail'])->middleware(['auth', 'role:administrador'])->name('show_Register_Visitor_Detail');

Route::get('/registro', [VisitorController::class, 'showRegisterVisitor'])->middleware(['auth', 'role:operador'])->name('show_register');

Route::post('/guardar-registro', [VisitorController::class, 'saveVisitor'])->middleware(['auth', 'role:operador'])->name('guardar_RegistroVisitor');

Route::get('/reporte', [VisitorController::class, 'showAccount'])->middleware(['auth', 'role:administrador'])->name('show_Account');
Route::post('/reporte', [VisitorController::class, 'accountConsul']);

Route::get('/dashboard', [Dashboard::class, 'showDashboard'])->middleware(['auth', 'role:administrador'])->name('show_Dashboard');
Route::post('/dashboard', [Dashboard::class, 'dashboard'])->middleware('auth')->name('Dashboard');

Route::get('/visitor/photo/{filename}', [VisitorController::class, 'getVisitorPhoto'])->name('visitor.photo');

Route::resource('filiales', FilialController::class)
    ->parameters(['filiales' => 'filial'])
    ->middleware(['auth', 'role:administrador']);
Route::resource('gerencias', GerenciaController::class)->middleware(['auth', 'role:administrador']);
