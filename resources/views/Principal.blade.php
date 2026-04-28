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
            <a class="navbar-brand fw-bold text-danger" href="/Principal"><img src="/img/logo.png" alt="Fuerza Urbana"
                    height="60"></a>

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
<!-- Carrusel -->
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/principal/foto1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="fw-bold display-6">Dominá cada paso</h5>
                    <p class="lead">Preparadas para cualquier desafío.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/principal/foto2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="fw-bold display-6">Jugá sin límites</h5>
                    <p class="lead">Precisión, agarre y potencia en cada jugada.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/principal/foto3.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="fw-bold display-6">Estilo urbano deportivo</h5>
                    <p class="lead">Ideal para entrenar o salir con estilo.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<!-- CARD -->
    <section class="productos-pricipal py-5">
        <div class="container">
            <h2 class="text-center mb-5 text-white text-uppercase fw-bold">Productos Destacados</h2>

            <div class="row g-0">

                <div class="col-md-4">
                    <a href="/Catalogos-de-productos" class="banner-card">
                        <img src="img/img1.jpg" alt="Remeras Urbanas">
                        <div class="banner-overlay">
                            <div class="banner-content text-center">
                                <h3 class="banner-title text-uppercase fw-bold">Remeras Urbanas</h3>
                                <span class="btn-banner">CONOCER MÁS</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="/Catalogos-de-productos" class="banner-card">
                        <img src="img/img2.jpg" alt="Zapatillas">
                        <div class="banner-overlay">
                            <div class="banner-content text-center">
                                <h3 class="banner-title text-uppercase fw-bold">Calzado Pro</h3>
                                <span class="btn-banner">CONOCER MÁS</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="/Catalogos-de-productos" class="banner-card">
                        <img src="img/img3.jpg" alt="Shorts">
                        <div class="banner-overlay">
                            <div class="banner-content text-center">
                                <h3 class="banner-title text-uppercase fw-bold">Shorts Deportivos</h3>
                                <span class="btn-banner">CONOCER MÁS</span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
    <!-- OPNIONES -->
    <section class="testimonios py-5 bg-black text-white">
        <div class="container text-center">
            <h2 class="mb-5 fw-bold text-uppercase">Opiniones</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="p-4 border border-secondary rounded">
                        <p class="fst-italic">"La calidad es tan buena que hasta mi ex me pidió la remera de vuelta.
                            Obviamente no se la di."</p>
                        <h5 class="text-danger fw-bold">- Julio Caceres</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border border-secondary rounded">
                        <p class="fst-italic">"Envío rápido y las zapas aguantan todo el entrenamiento. 10/10."</p>
                        <h5 class="text-danger fw-bold">- Lucas Gaitan</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border border-secondary rounded">
                        <p class="fst-italic">"Buscaba algo diferente y acá lo encontré. El estilo urbano que faltaba en
                            el barrio."</p>
                        <h5 class="text-danger fw-bold">- Micaela Soto</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- POR QUE ELEGIRNOS -->
    <section class="beneficios">
        <div class="container text-center">
            <h2>¿Por que elegirnos?</h2>
            <div class="row">
                <div class="col-md-3">
                    <h4>Envios</h4>
                    <p>Envios a todo el pais</p>
                </div>
                <div class="col-md-3">
                    <h4>Pagos seguros</h4>
                    <p>Proteccion garantizada</p>
                </div>
                <div class="col-md-3">
                    <h4>Calidad</h4>
                    <p>A tu alcance</p>
                </div>
                <div class="col-md-3">
                    <h4>Cambios</h4>
                    <p>30 días para cambios</p>
                </div>
            </div>
        </div>
    </section>
    <!-- DESCUENTO -->
    <section class="promo text-center">
        <h2>20% OFF en indumentaria deportiva</h2>
        <p>Solo por tiempo limitado</p>
        <a class="btn btn-outline-light"
        href="/Catalogos-de-productos">Ver Productos</a>
        

    </section>

    <!-- FOOTER -->
<footer class="footer bg-black text-center text-light py-4 border-top border-danger">
    <p class="mb-1">@Fuerza Urbana</p>
    <p class="text-secondary">Instagram | WhatsApp | Contacto</p>
    <p class="mb-0">© Fuerza Urbana — Todos los derechos reservados</p>
</footer>
    <script>
        // Guarda la posición anterior del scroll
        let lastScroll = 0;

        // Selecciona el navbar
        const navbar = document.querySelector(".navbar");

        // Detecta cuando el usuario hace scroll
        window.addEventListener("scroll", function () {

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