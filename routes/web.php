<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductoPublicoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MisComprasController;
use App\Http\Controllers\ContactoController;   // ← NUEVO

// ── RUTAS PÚBLICAS ─────────────────────────────────────────────
Route::get('/',                         fn() => view('Principal'));
Route::get('/Principal',                fn() => view('Principal'))->name('Principal');
Route::get('/Quienes-somos',            fn() => view('Quienes-somos'));
Route::get('/Comercializacion',         fn() => view('Comercializacion'));
Route::get('/Informacion-de-contacto',  fn() => view('Informacion-de-contacto'));
Route::get('/Terminos-y-usos',          fn() => view('Terminos-y-usos'));

// Contacto — procesar formulario (público, funciona con y sin login)
Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');

// Catálogo
Route::get('/Catalogos-de-productos', [ProductoPublicoController::class, 'index'])->name('catalogo');
Route::get('/productos/{slug}',        [ProductoPublicoController::class, 'show'])->name('productos.show');

// Carrito público
Route::get('/Carrito', [CarritoController::class, 'index'])->name('carrito.index');

// ── AUTENTICACIÓN ───────────────────────────────────────────────
Route::get('/Login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/Login',    [AuthController::class, 'login']);
Route::get('/Register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/Register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── RUTAS PROTEGIDAS ────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/productos/{id}/carrito', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{id}',          [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{id}',         [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito',              [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

    Route::get('/Mis-compras',      [MisComprasController::class, 'index'])->name('cliente.ordenes');
    Route::get('/mis-compras/{id}', [MisComprasController::class, 'show'])->name('mis-compras.detalle');

    Route::get('/checkout',                       [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout',                      [CheckoutController::class, 'procesar'])->name('checkout.procesar');
    Route::get('/checkout/comprobante/{orderId}', [CheckoutController::class, 'comprobante'])->name('checkout.comprobante');
});

// ── PANEL ADMIN ─────────────────────────────────────────────────
require __DIR__.'/admin.php';