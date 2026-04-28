<!doctype html>
<html lang="es" data-bs-theme="dark">

<head>
    <title>Contacto - Fuerza Urbana</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

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

    <main>

        <!-- HERO -->
        <section class="hero d-flex align-items-center text-center text-white">
            <div class="container">
                <h1 class="display-4 fw-bold">Contacto</h1>
                <p class="lead">Estamos para ayudarte</p>
            </div>
        </section>

        <!-- INFO + FORM -->
        <section class="py-5 bg-dark text-light">
            <div class="container">
                <div class="row">

                    <!-- DATOS -->
                    <div class="col-md-5 mb-4">

                        <h3 class="text-danger mb-4">Información Legal</h3>

                        <p><strong>Titular:</strong> Lucas Benítez</p>
                        <p><strong>Razón Social:</strong> Fuerza Urbana S.R.L.</p>
                        <p><strong>Domicilio:</strong> Av. Independencia 1234, Corrientes, Argentina</p>
                        <p><strong>Teléfono:</strong> +54 379 4123456</p>
                        <p><strong>Email:</strong> contacto@fuerzaurbana.com</p>

                        <h4 class="text-danger mt-4">Redes</h4>
                        <p>Instagram: @fuerzaurbana</p>
                        <p>WhatsApp: +54 379 4123456</p>

                        <div class="mt-4">
                            <h4 class="text-danger mb-3">Nuestra ubicación</h4>

                            <div class="mapa">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.9999999999995!2d-58.8344!3d-27.4806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456b1234567890%3A0x123456789abcdef!2sCorrientes%2C%20Argentina!5e0!3m2!1ses!2sar!4v0000000000000"
                                    width="100%"
                                    height="300"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>

                    </div>

                    <!-- FORMULARIO -->
                    <div class="col-md-7">

                        <h3 class="text-danger mb-4">Envíanos un mensaje</h3>

                        <form>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Nombre completo*" required>
                            </div>

                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Correo electrónico*" required>
                            </div>

                            <div class="mb-3">
                                <input type="tel" class="form-control" placeholder="Teléfono">
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control" rows="5" placeholder="Escribí tu mensaje..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger w-100">Enviar mensaje</button>

                        </form>

                    </div>

                </div>
            </div>
        </section>

    </main>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>