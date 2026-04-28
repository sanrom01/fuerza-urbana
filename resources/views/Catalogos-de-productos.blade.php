<!DOCTYPE html>
<html lang="es">
<head>
    <title>Catalogo Deportivo</title>

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
                    <a class="nav-link btn btn-danger ms-3 px-3" href="/Catalogos-de-productos">Catálogo</a>
                </div>
            </div>
        </div>
    </nav>


    <section class="hero text-center d-flex align-items-center">
    <div class="container">
        <h1 class="fw-bold display-5">Catálogo Deportivo</h1>
        <p class="lead">Equipate con lo mejor en rendimiento y estilo</p>
    </div>
    </section>


<section  class="container mt-5" id="productos">
    <div class="row">

        <!-- FILTROS -->
        <aside class="col-lg-3 filtros shadow-sm rounded">
            <h5 class="fw-bold mb-3">PRODUCTOS</h5>

            <ul class="lista-categorias">
                <li>Remeras</li>
                <li>Shorts</li>
                <li>Zapatillas</li>
                <li>Buzos</li>
            </ul>

            <h6 class="mt-4 fw-bold">Filtrar por</h6>

            <p class="mt-3 mb-1">Color</p>

            <div class="filtro-item"><input type="checkbox"> Negro <span class="color negro"></span></div>
            <div class="filtro-item"><input type="checkbox"> Blanco <span class="color blanco"></span></div>
            <div class="filtro-item"><input type="checkbox"> Rojo <span class="color rojo"></span></div>
            <div class="filtro-item"><input type="checkbox"> Azul <span class="color azul"></span></div>

        </aside>

        <!-- PRODUCTOS -->
        <main class="col-lg-9">
            <div class="productos-grid">

                <!-- PRODUCTO -->
                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/remera.jpeg" alt="Remera Running Pro">

                    <div class="p-3 text-center">
                        <h6>Remera Running Pro</h6>
                        <p class="precio">$18.000</p>
                        <p class="cuotas">6 cuotas sin interés</p>
                        <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/remera2.jpg" alt="Remera Independiente Retro">
                    <div class="p-3 text-center">
                        <h6>Remera Independiente Retro</h6>
                        <p class="precio">$24.000</p>
                        <p class="cuotas">6 cuotas sin interés</p>
                        <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/remera3.jpg" alt="Remera Argentina">
                    <div class="p-3 text-center">
                        <h6>Remera Argentina</h6>
                        <p class="precio">$30.000</p>
                        <p class="cuotas">6 cuotas sin interés</p>
                        <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/remera4.jpg" alt="Remera Retro Napoli">
                    <div class="p-3 text-center">
                        <h6>Remera Retro Napoli</h6>
                        <p class="precio">$24.000</p>
                        <p class="cuotas">6 cuotas sin interés</p>
                        <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/remera5.jpeg" alt="Remera Kobe 24">

                    <div class="p-3 text-center">
                        <h6>Remera Kobe 24</h6>
                        <p class="precio">$25.000</p>
                        <p class="cuotas">6 cuotas sin interés</p>
                        <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>

                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/short.jpeg">
                    <div class="p-3 text-center">
                    <h6>Short Training</h6>
                    <p class="precio">$14.500</p>
                    <p class="cuotas">6 cuotas sin interés</p> 
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/short2.jpeg">
                    <div class="p-3 text-center">
                    <h6>Short Toronto</h6>
                    <p class="precio">$14.500</p>
                    <p class="cuotas">6 cuotas sin interés</p> 
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/short3.jpeg">
                    <div class="p-3 text-center">
                    <h6>Short Hummel</h6>
                    <p class="precio">$14.500</p>
                    <p class="cuotas">6 cuotas sin interés</p> 
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/short4.jpeg">
                    <div class="p-3 text-center">
                    <h6>Short Mandiyu</h6>
                    <p class="precio">$14.500</p>
                    <p class="cuotas">6 cuotas sin interés</p> 
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/short5.jpg">
                    <div class="p-3 text-center">
                    <h6>Short Training Pink</h6>
                    <p class="precio">$14.500</p>
                    <p class="cuotas">6 cuotas sin interés</p> 
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>

                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/zapatilla.jpeg">
                    <div class="p-3 text-center">
                    <h6>Zapatillas Adidas Running Lite</h6>
                    <p class="precio">$65.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button>                   
                    </div>
                </div>

                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/zapatilla2.jpg">
                    <div class="p-3 text-center">
                    <h6>Zapatillas Puma Urban Trainer</h6>
                    <p class="precio">$65.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button>                   
                    </div>
                </div> 
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/zapatilla3.jpg">
                    <div class="p-3 text-center">
                    <h6>Zapatillas Nike Air Flex</h6>
                    <p class="precio">$65.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button>                   
                    </div>
                </div>
                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/zapatilla4.jpg">
                    <div class="p-3 text-center">
                    <h6>Zapatillas Nike SpeedRun</h6>
                    <p class="precio">$65.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button>                   
                    </div>
                </div> 
                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/zapatilla5.jpeg">
                    <div class="p-3 text-center">
                    <h6>Zapatillas Umbro Indoor Pro</h6>
                    <p class="precio">$65.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button>                   
                    </div>
                    </div>
                <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/buzo.jpeg">
                    <div class="p-3 text-center">
                    <h6>Buzo Deportivo</h6>
                    <p class="precio">$38.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/buzo2.jpeg">
                    <div class="p-3 text-center">
                    <h6>Buzo Independiente</h6>
                    <p class="precio">$38.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/buzo3.jpeg">
                    <div class="p-3 text-center">
                    <h6>Buzo Argentina</h6>
                    <p class="precio">$38.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/buzo4.jpeg">
                    <div class="p-3 text-center">
                    <h6>Buzo Liverpool</h6>
                    <p class="precio">$38.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>
                    <div class="producto shadow-sm rounded overflow-hidden">
                    <img src="img/catalogo/buzo5.jpeg">
                    <div class="p-3 text-center">
                    <h6>Buzo Alemania</h6>
                    <p class="precio">$38.000</p>
                    <p class="cuotas">6 cuotas sin interés</p>
                    <button class="btn btn-danger btn-sm mt-2">
                        Comprar
                    </button> 
                    </div>
                </div>

            </div>
        </main>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>