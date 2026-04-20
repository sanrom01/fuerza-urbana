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
Route::get('/Contacto', function () {
return view('Informacion-de-contacto');
});
Route::get('/Terminos', function () {
return view('Terminos-y-Uso');
});
Route::get('/Catalogo', function () {
return view('Catalogos-de-productos');
});
Route::post('/contacto', [ContactoController::class, 'procesar']); 