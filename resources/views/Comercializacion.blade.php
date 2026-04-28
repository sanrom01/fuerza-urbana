<!DOCTYPE html>
<html>

<head>
    <title>Principal</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAV -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="/Principal"><img src="/img/logo.png" alt="Fuerza Urbana" height="60"></a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="menu" class="collapse navbar-collapse justify-content-end">
                <div class="navbar-nav">
                    <a class="nav-link" href="/Principal">Inicio</a>
                    <a class="nav-link active" href="/Quienes-somos">Quiénes somos</a>
                    <a class="nav-link" href="/Comercializacion">Comercialización</a>
                    <a class="nav-link" href="/Informacion-de-contacto">Contacto</a>
                    <a class="nav-link" href="/Terminos-y-usos">Términos</a>
                    <a class="nav-link" href="/Catalogos-de-productos">Catálogo</a>
                </div>
            </div>
        </div>
    </nav>
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


    <!-- FOOTER -->
    <footer class="footer bg-black text-center text-light py-4 border-top border-danger">
        <p class="mb-1">@Fuerza Urbana</p>
        <p class="text-secondary">Instagram | WhatsApp | Contacto</p>
        <p class="mb-0">© Fuerza Urbana — Todos los derechos reservados</p>
    </footer>
    <!-- Ocular el navbar-->
    <script>
        // Guarda la posición anterior del scroll
        let lastScroll = 0;

        // Selecciona el navbar
        const navbar = document.querySelector(".navbar");

        // Detecta cuando el usuario hace scroll
        window.addEventListener("scroll", function() {

            let currentScroll = window.pageYOffset;

            // Si el usuario baja, ocultar navbar
            if (currentScroll > lastScroll) {
                navbar.style.top = "-80px";
            }
            // Si sube, mostrar navbar
            else {
                navbar.style.top = "0";
            }

            // Actualiza la posición del scroll
            lastScroll = currentScroll;

        });
    </script>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>