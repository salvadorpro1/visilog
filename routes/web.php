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

// Rutas públicas
Route::get('/', [AuthenticateUserController::class, "showLoginForm"])->middleware('auth.redirect')->name('login');
Route::post('/login', [AuthenticateUserController::class, "login"]);
Route::get('/logout', [AuthenticateUserController::class, 'logout'])->name('logout');

// Rutas protegidas por 'auth' para todos los usuarios
Route::middleware('auth')->group(function () {


    Route::get('/get-gerencias/{filial_id}', [VisitorController::class, 'getGerenciasByFilial'])->name('getGerenciasByFilial');


    // Cambiar contraseña
    Route::get('/mostrar-cambiar-contraseña', [AuthenticateUserController::class, "showChangePassword"])->name('changePassword');
    Route::post('/cambiar-contraseña', [AuthenticateUserController::class, 'changePassword']);

    // Rutas para 'operador'
    Route::middleware('role:operador')->group(function () {
        Route::get('/consulta', [VisitorController::class, 'showConsulForm'])->name('show_consult');
        Route::post('/consulta', [VisitorController::class, 'consulDate']);
        Route::get('/registro', [VisitorController::class, 'showRegisterVisitor'])->name('show_register');
        Route::post('/guardar-registro', [VisitorController::class, 'saveVisitor'])->name('guardar_RegistroVisitor');
    });

    // Rutas para 'administrador'
    Route::middleware('role:administrador')->group(function () {
        Route::get('/operador', [AuthenticateUserController::class, 'showRegister'])->name('showRegisterCreate');
        Route::post('/operador', [AuthenticateUserController::class, 'saveRegistrar'])->name('create_operator');
        Route::get('/operador/historial/{id}', [AuthenticateUserController::class, 'showHistory'])->name('history_Operator');
        Route::post('/operador/desactivar/{id}', [AuthenticateUserController::class, 'deactivateOperator'])->name('deactivate_Operator');

        Route::get('/registro-de-visitantes', [VisitorController::class, 'showRegister'])->name('show_Register_Visitor');
        Route::get('/registro-de-visitantes/{cedula}', [VisitorController::class, 'showRegisterDetail'])->name('show_Register_Visitor_Detail');
        Route::get('/reporte', [VisitorController::class, 'showAccount'])->name('show_Account');
        Route::post('/reporte', [VisitorController::class, 'accountConsul']);
        Route::get('/dashboard', [Dashboard::class, 'showDashboard'])->name('show_Dashboard');
        Route::post('/dashboard', [Dashboard::class, 'dashboard'])->name('Dashboard');
        Route::resource('filiales', FilialController::class)->parameters(['filiales' => 'filial']);
        Route::resource('gerencias', GerenciaController::class);
        Route::get('/download-report', [VisitorController::class, 'downloadReport'])->name('download_report');
    });
});