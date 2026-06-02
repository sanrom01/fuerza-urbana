@extends('layouts.app')

@section('title', 'Mis Compras - Fuerza Urbana')

@section('content')
<div class="container text-white" style="padding-top: 100px; padding-bottom: 50px;">
    <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 2px;">📦 MIS COMPRAS</h2>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark border-secondary mb-3 shadow" style="border-radius: 15px;">
                <div class="card-header bg-black border-secondary d-flex justify-content-between align-items-center p-3" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <div>
                        <span class="text-secondary small">Pedido N°:</span> <strong class="text-white">#00124</strong>
                        <span class="mx-2 text-secondary">|</span>
                        <span class="text-secondary small">Fecha:</span> <strong class="text-white">02/06/2026</strong>
                    </div>
                    <span class="badge bg-warning text-dark fw-bold text-uppercase px-3 py-2 rounded-pill">
                        Preparando
                    </span>
                </div>
                
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h6 class="fw-bold text-uppercase mb-1">Remera Oversize Black (x1)</h6>
                            <p class="text-secondary small mb-0">Código de seguimiento: <code class="text-danger">FU-983742-AR</code></p>
                        </div>
                        <div class="col-md-2 text-md-center mt-3 mt-md-0">
                            <span class="text-secondary small d-block">Total pagado:</span>
                            <span class="fw-bold text-danger">$25.000</span>
                        </div>
                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                            <a href="/compras/00124" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
    </div>
</div>
@endsection