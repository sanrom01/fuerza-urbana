<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    ProductoController,
    CategoriaController,
    UsuarioController,
    ConsultaController,
    VentaController,
    FacturaController,
    ReporteController,
};

// ──────────────────────────────────────────────────────────────
//  PANEL DE ADMINISTRACIÓN
//  Middleware: auth (usuario autenticado) + admin (rol admin)
//  Agregar en bootstrap/app.php:
//    ->withMiddleware(function (Middleware $middleware) {
//        $middleware->alias(['admin' => \App\Http\Middleware\AdminMiddleware::class]);
//    })
// ──────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Productos
        Route::get('productos/restaurar/{id}', [ProductoController::class, 'restore'])->name('productos.restore');
        Route::resource('productos', ProductoController::class);

        // Categorías
        Route::get('categorias/restaurar/{id}', [CategoriaController::class, 'restore'])->name('categorias.restore');
        Route::resource('categorias', CategoriaController::class);

        // Usuarios
        Route::get('usuarios',                       [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/{usuario}',             [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('usuarios/{usuario}/editar',      [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('usuarios/{usuario}',             [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('usuarios/{usuario}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::post('usuarios/{id}/restaurar',       [UsuarioController::class, 'restore'])->name('usuarios.restore');

        // Consultas
        Route::get('consultas',                          [ConsultaController::class, 'index'])->name('consultas.index');
        Route::get('consultas/{consulta}',               [ConsultaController::class, 'show'])->name('consultas.show');
        Route::post('consultas/{consulta}/responder',    [ConsultaController::class, 'responder'])->name('consultas.responder');
        Route::delete('consultas/{consulta}',            [ConsultaController::class, 'destroy'])->name('consultas.destroy');

        // Ventas
        Route::get('ventas',                             [VentaController::class, 'index'])->name('ventas.index');
        Route::get('ventas/{venta}',                     [VentaController::class, 'show'])->name('ventas.show');
        Route::patch('ventas/{venta}/estado',            [VentaController::class, 'cambiarEstado'])->name('ventas.estado');

        // Facturación
        Route::get('facturacion',                        [FacturaController::class, 'index'])->name('facturacion.index');
        Route::get('facturacion/{factura}',              [FacturaController::class, 'show'])->name('facturacion.show');
        Route::get('facturacion/{factura}/pdf',          [FacturaController::class, 'descargarPdf'])->name('facturacion.pdf');

        // Reportes
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    });