<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarcaController;

Route::get('/', function () {
   return view('auth.login');
});
route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name(  'login');
route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    
    // Página principal tras autenticarse (Dashboard)
    Route::get('/principal', function () {
        return view('principal.principal');
    })->name('principal');

    // Rutas para crear nuevos usuarios
    Route::get('/usuarios/nuevo', [AuthController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/guardar', [AuthController::class, 'store'])->name('usuarios.store');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    //Rutas para nueva marca
    Route::get('/marcas/nueva', [MarcaController::class, 'create'])->name('marcas.create');
    Route::post('/marcas/guardar', [MarcaController::class, 'store'])->name('marcas.store');
});



