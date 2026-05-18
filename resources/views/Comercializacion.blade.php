@extends('layouts.app')

@section('title', 'comercialización')

@section('content')

    <section class="hero d-flex align-items-center text-center text-white">
        <div class="container">
            <h1 class="display-4 fw-bold">Comercializacion</h1>
            <p class="lead">Conoce nuestras opciones de entrega, Envios y Metodos de pago</p>
        </div>
    </section>
    <!--TIPOS DE ENTREGA -->
    <section class="entregas py-5">
        <div class="container">
            <h2 class="text-center text-danger fw-bold mb-4">Tipos de Entrega</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <img src="img/domicilio.jpg" class="icono-pago">
                    <h4>Entregas a domiciolio</h4>
                    <p>Recibi tu compra directamente en tu casa con envios a todo el pais</p>
                </div>
                <div class="col-md-4">
                    <img src="img/puntoEntrega.jpg" class="icono-pago">
                    <h4>Retiro en punto de entrega</h4>
                    <p>Podes retirar tu pedido en nuestro puntos habilitados.</p>
                </div>
                <div class="col-md-4">
                    <img src="img/express.jpg" class="icono-pago">
                    <h4>Entrega express</h4>
                    <p>En alguna ciudades ofrecemos entregas rapidas dentro de las 24 a 48 horas</p>
                </div>
            </div>
        </div>
    </section>
    <!-- FORMAS DE ENVIO -->
    <section class="envios p5-y bg-dark text-white">
        <div class="container">
            <h2 class="text-center text-danger fw-bold mb-4">Formas de Envio</h2>
            <ul class="text-center">
                <li>Envios a todo el pais</li>
                <li>Correo Argentino</li>
                <li>Empresas de logisticas privadas</li>
                <li>Seguimientos de pedido una vez despachado</li>
            </ul>
        </div>
    </section>
    <!-- METODOS DE PAGO-->
    <section class="pagos py-5">
        <div class="container">
            <h2 class="text-center text-danger fw-bold mb-4">Metodos de Pago</h2>
            <div class="row text-center">
                <div class="col-md-3">
                    <img src="img/tarjetaCredito.jpg" class="icono-pago">
                    <h3>Tarjetas de creditos</h3>
                </div>
                <div class="col-md-3">
                    <img src="img/mercadoPago.jpg" class="icono-pago">
                    <h3>Mercado Pago</h3>
                </div>
                <div class="col-md-3">
                    <img src="img/transferencia.jpg" class="icono-pago">
                    <h3>Transferencia bancaria</h3>
                </div>
                <div class="col-md-3">
                    <img src="img/efectivo.jpg" class="icono-pago">
                    <h3>Efectivo</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- INFORMACION ADICIONAL -->
    <section class="info py-5 bg-dark text-white">
        <div class="container text-center">
            <h2 class="text-center text-danger fw-bold mb-4">Información adicional</h2>
            <p>Los pedidos tienen un tiempo estimado de entrega de 3 a 7 días hábiles dependiendo de la ubicación.</p>
            <p>Todos los productos cuentan con garantía y cambios dentro de los 30 días posteriores a la compra.</p>
            <p>Para cualquier consulta podés comunicarte con nosotros a través de nuestras redes sociales o WhatsApp.</p>

        </div>
    </section>

    @endsection