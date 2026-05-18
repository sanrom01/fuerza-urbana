@extends('layouts.app')

@section('title', 'Términos y Condiciones')

@section('content')


    <section class="hero-legal text-center text-white d-flex align-items-center">
        <div class="container">
            <h1 class="fw-bold display-5">Términos y Condiciones</h1>
            <p class="text-secondary">Última actualización: 2026</p>
        </div>
    </section>

    <!-- CONTENIDO -->
    <section class="py-5 bg-dark text-light">
        <div class="container col-lg-9">

            <p class="lead text-secondary">
                Este documento regula el uso del sitio web de <strong>Fuerza Urbana</strong> y la compra de productos dentro de nuestra plataforma.
            </p>

            <!-- SECCIÓN 1 -->
            <div class="legal-block">
                <h4 class="text-danger">1. Uso del sitio</h4>
                <p>
                    El usuario se compromete a utilizar este sitio de forma legal, sin alterar su funcionamiento ni realizar actividades fraudulentas.
                </p>
            </div>

            <!-- SECCIÓN 2 -->
            <div class="legal-block">
                <h4 class="text-danger">2. Productos</h4>
                <p>
                    Todos los productos están sujetos a disponibilidad. Fuerza Urbana puede modificar precios, stock o características sin previo aviso.
                </p>
            </div>

            <!-- SECCIÓN 3 -->
            <div class="legal-block">
                <h4 class="text-danger">3. Pagos</h4>
                <ul>
                    <li>Tarjetas de crédito / débito</li>
                    <li>Transferencia bancaria</li>
                    <li>Mercado Pago</li>
                </ul>
            </div>

            <!-- SECCIÓN 4 -->
            <div class="legal-block">
                <h4 class="text-danger">4. Envíos</h4>
                <p>
                    Envíos a todo el país. Tiempo estimado: <strong>3 a 7 días hábiles</strong>. Puede variar según ubicación.
                </p>
            </div>

            <!-- SECCIÓN 5 -->
            <div class="legal-block">
                <h4 class="text-danger">5. Cambios y devoluciones</h4>
                <p>
                    Se aceptan cambios dentro de los <strong>30 días posteriores</strong> a la compra del producto.
                    El producto debe estar sin uso y en su empaque original.
                </p>
            </div>

            <!-- SECCIÓN 6 -->
            <div class="legal-block">
                <h4 class="text-danger">6. Garantía</h4>
                <p>
                    Garantía por defectos de fabricación. No incluye daños por uso indebido.
                </p>
            </div>

            <!-- SECCIÓN 7 -->
            <div class="legal-block">
                <h4 class="text-danger">7. Privacidad</h4>
                <p>
                    Los datos personales son utilizados únicamente para procesamiento de pedidos y no serán compartidos con terceros.
                </p>
            </div>

            <!-- CTA FINAL -->
            <div class="text-center mt-5">
                <p class="text-secondary">
                    Al continuar usando este sitio, aceptas estos términos.
                </p>
            </div>

        </div>
    </section>

    </main>

@endsection

   