<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// ── RUTAS PÚBLICAS ─────────────────────────────────────────────
Route::get('/',                    fn() => view('Principal'));
Route::get('/Principal',           fn() => view('Principal'))->name('Principal');
Route::get('/Quienes-somos',       fn() => view('Quienes-somos'));
Route::get('/Comercializacion',    fn() => view('Comercializacion'));
Route::get('/Informacion-de-contacto', fn() => view('Informacion-de-contacto'));
Route::get('/Terminos-y-usos',     fn() => view('Terminos-y-usos'));
Route::get('/Catalogos-de-productos', fn() => view('Catalogos-de-productos'));

// ── AUTENTICACIÓN MANUAL ───────────────────────────────────────
Route::get('/Login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/Login',   [AuthController::class, 'login']);

Route::get('/Register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/Register',[AuthController::class, 'register']);

Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ── RUTAS PROTEGIDAS (solo usuarios logueados) ─────────────────
Route::middleware('auth')->group(function () {

    Route::get('/Carrito', fn() => view('carrito'))->name('carrito.index');

    Route::get('/Mis-compras', fn() => view('mis-compras'))->name('cliente.ordenes');

    Route::get('/profile/edit', fn() => view('profile.edit'))->name('profile.edit');

});

// ── PANEL ADMIN ────────────────────────────────────────────────
require __DIR__.'/admin.php';