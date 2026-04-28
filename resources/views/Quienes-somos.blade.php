<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
    <title>Fuerza Urbana</title>
    
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
            <h1 class="display-4 fw-bold">Quiénes Somos</h1>
            <p class="lead">Conocé nuestra historia y lo que nos impulsa</p>
        </div>
    </section>

    <!-- CONTENIDO -->
    <section class="py-5 bg-dark text-light">
        <div class="container col-md-8 text-center">
            <p class="fs-5">
                La sección “Quiénes Somos” de Fuerza Urbana está pensada para acercarte a la esencia de nuestra marca y mostrar todo lo que hay detrás de cada prenda que ofrecemos.
            </p>

            <p>
                Nos dedicamos a la venta de indumentaria deportiva con un objetivo claro: acompañar a cada persona en su camino hacia una vida más activa, cómoda y segura.
            </p>

            <p>
                Nuestra trayectoria nace del compromiso y la pasión por el deporte. Hemos crecido mejorando calidad, diseño y adaptándonos a las tendencias sin perder nuestra identidad.
            </p>

            <p>
                Nuestro equipo está formado por profesionales en diseño, ventas y atención al cliente, enfocados en brindarte la mejor experiencia.
            </p>

            <p class="fw-bold text-danger">
                Más que una marca, somos una comunidad. Vestimos tu energía.
            </p>
        </div>
    </section>

     <!-- HISTORIA -->
    <section class="py-5 bg-dark text-light">
        <div class="container col-md-8">

            <h2 class="text-center text-danger fw-bold mb-4">Nuestra Historia</h2>

            <p>
                <strong>Fuerza Urbana</strong> nació en el año 2016 en la ciudad de Corrientes, Argentina, en un pequeño local que apenas superaba los 30 metros cuadrados.
                Sus fundadores, <strong>Lucas Benítez</strong>, profesor de educación física, y <strong>Martina Ríos</strong>, diseñadora textil, compartían una misma inquietud:
                la falta de indumentaria deportiva que combinara calidad, estilo urbano y precios accesibles.
            </p>

            <p>
                Todo comenzó de manera muy simple. Lucas, que trabajaba en gimnasios y entrenaba grupos al aire libre, notaba que muchas personas utilizaban ropa incómoda o de baja durabilidad.
                Por su parte, Martina veía una oportunidad desde el diseño: crear prendas funcionales, pero con identidad moderna.
            </p>

            <p>
                Al principio, confeccionaban pequeñas tandas de ropa que vendían a conocidos y a través de redes sociales.
                La respuesta fue inmediata: la gente valoraba tanto la calidad como el estilo distintivo de la marca.
            </p>

            <p>
                Con el paso de los años, <strong>Fuerza Urbana</strong> fue creciendo de forma sostenida. En 2018 ampliaron su producción e incorporaron nuevos integrantes al equipo.
                Para 2020, ya contaban con una tienda física más grande y ventas online a distintas provincias.
            </p>

            <p>
                Uno de los momentos clave fue en 2021, cuando profesionalizaron la empresa, mejoraron procesos y fortalecieron su identidad.
                Esto les permitió posicionarse dentro del mercado de la indumentaria deportiva.
            </p>

            <p class="fw-bold text-center text-danger mt-4">
                Hoy somos una empresa en crecimiento constante, impulsada por la pasión, el esfuerzo y la superación.
            </p>

        </div>

        <!-- LINEA DE TIEMPO -->
    <section class="timeline-section bg-black text-light py-5">
        <div class="container">
            <h2 class="text-center text-danger mb-5">Evolución</h2>

            <div class="timeline">

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h4>2016</h4>
                        <p>Nace Fuerza Urbana en un pequeño local.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h4>2018</h4>
                        <p>Expansión de producción y primeras ventas masivas.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h4>2020</h4>
                        <p>Lanzamiento de tienda online y crecimiento nacional.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h4>2021</h4>
                        <p>Profesionalización y consolidación de la marca.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h4>Hoy</h4>
                        <p>Empresa mediana en constante crecimiento.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- EQUIPO -->
    <section class="py-5 bg-dark text-light">
        <div class="container text-center">
            <h2 class="text-danger fw-bold mb-5">Nuestro Equipo</h2>

            <div class="row">

                <div class="col-md-4">
                    <div class="card bg-dark text-light border-0">
                        <img src="/img/lucas.jpg" class="card-img-top" alt="Lucas">
                        <div class="card-body">
                            <h5>Lucas Benítez</h5>
                            <p class="text-danger">Fundador</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-dark text-light border-0">
                        <img src="/img/martina.jpg" class="card-img-top" alt="Martina">
                        <div class="card-body">
                            <h5>Martina Ríos</h5>
                            <p class="text-danger">Diseñadora</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-dark text-light border-0">
                        <img src="/img/equipo.jpg" class="card-img-top" alt="Equipo">
                        <div class="card-body">
                            <h5>Equipo FU</h5>
                            <p class="text-danger">Staff</p>
                        </div>
                    </div>
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