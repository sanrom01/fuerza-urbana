<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Principal', function () {
return view('Principal');
});
Route::get('/Quienes-somos', function () {
return view('Quienes-somos');
});
Route::get('/Comercializacion', function () {
return view('Comercializacion');
});
Route::get('/Informacion-de-contacto', function () {
return view('Informacion-de-contacto');
});
Route::get('/Terminos-y-usos', function () {
return view('Terminos-y-usos');
});
Route::get('/Catalogos-de-productos', function () {
return view('Catalogos-de-productos');
});
Route::view('/Login', 'Login')->name('login');
Route::view('/Register', 'register')->name('register');
Route::post('/contacto', [ContactoController::class, 'procesar']); 

Route::get('/Carrito', function () {
    return view('carrito');
})->name('carrito');

Route::get('/Mis-compras', function () {
    return view('mis-compras');
})->name('mis-compras');
use App\Http\Controllers\UsuarioController;

Route::post('/registro',
    [UsuarioController::class,'guardar'])
    ->name('registro.guardar');