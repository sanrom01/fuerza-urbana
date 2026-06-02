@extends('layouts.app')

@section('title', 'Mi Carrito - Fuerza Urbana')

@section('content')
<div class="container text-white" style="padding-top: 100px; padding-bottom: 50px;">
    <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 2px;">🛒 TU CARRITO</h2>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card bg-dark border-secondary p-3" style="border-radius: 15px;">
                <div class="row align-items-center mb-3 pb-3 border-bottom border-secondary">
                    <div class="col-3 col-md-2">
                        <img src="/img/productos/remera-oversize.jpg" class="img-fluid rounded" alt="Producto">
                    </div>
                    <div class="col-5 col-md-6">
                        <h5 class="fw-bold mb-1 text-uppercase">Remera Oversize Black</h5>
                        <p class="text-secondary small mb-0">Talle: XL</p>
                        <h6 class="text-danger fw-bold mt-1">$25.000</h6>
                    </div>
                    <div class="col-4 col-md-4 text-end">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="mx-3 fw-bold">Cant: 1</span>
                            <button class="btn btn-sm btn-outline-danger ms-2">
                                <i class="bi bi-trash">Eliminar</i>
                            </button>
                        </div>
                    </div>
                </div>

                </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark border-secondary p-4 shadow-lg" style="border-radius: 15px;">
                <h4 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">RESUMEN</h4>
                <hr class="border-secondary">
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Subtotal</span>
                    <span>$25.000</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Envío</span>
                    <span class="text-success">Gratis</span>
                </div>
                
                <hr class="border-secondary">
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">TOTAL</span>
                    <span class="fw-bold fs-5 text-danger">$25.000</span>
                </div>

                <form action="/finalizar-compra" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold rounded-pill text-uppercase" style="font-size: 14px; letter-spacing: 1px;">
                        Iniciar Pago
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection