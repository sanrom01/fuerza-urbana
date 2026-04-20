<!DOCTYPE html>
<html>
<head>
<title>Principal</title>
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
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
</header>

 <section class="hero d-flex align-items-center text-center text-white py-5">
    <div class="container">
        <h1 class="display-4">La Mejor Calidad</h1>
        <p class="lead">Con los mejores precios</p>
    </div>
</section>

<section class="productos py-5">
        <div class="container">
        <h2 class="text-center mb-4">Nuestros Productos</h2>
    <div class="row">

        <div class="col-md-4">
        <div class="card">
            <img src="{{ asset('/img/img1.jpg') }}" class="card-img-top" alt="Camiseta deportiva">
            <div class="card-body text-center">
            <h5 class="card-title">Remera</h5>
            <p class="card-text">Comodidad y estilo</p>
        </div>
    </div>
    </div>

        <div class="col-md-4">
        <div class="card">
        <img src="{{ asset('img/img2.jpg') }}" class="card-img-top" alt="Zapatilla deportiva">
        <div class="card-body text-center">
            <h5 class="card-title">Zapatilla</h5>
            <p class="card-text">Máximo rendimiento</p>
        </div>
    </div>
    </div>

        <div class="col-md-4">
            <div class="card">
            <img src="{{ asset('img/img3.jpg') }}" class="card-img-top" alt="Short deportivo">
            <div class="card-body text-center">
            <h5 class="card-title">Short</h5>
            <p class="card-text">Libertad de movimiento</p>
        </div>
        </div>
    </div>

    </div>
    </div>
    </section>
<section class="beneficios">
    <div class="container text-center">
        <h2>¿Por que elegirnos?</h2>
        <div class="row">
            <div class= "col-md-3">
                <h4>Envios</h4>
                <p>Envios a todo el pais</p>
            </div>
            <div class="col-md-3">
                <h4>Pagos seguros</h4>
                <p>Proteccion garantizada</p>
            </div>
            <div class="col-md-3">
                <h4>Calidad</h4>
            </div>
            <div class="col-md-3">
            <h4>Cambios</h4>
            <p>30 días para cambios</p>
        </div>
        </div>
    </div>
</section>
<section class="promo text-center">
    <h2>20% OFF en indumentaria deportiva</h2>
    <p>Solo por tiempo limitado</p>
</section>
<footer class= "footer text-center">
    <p>@FuerzaUrbana</p>
    <p>Instragram| Whatsapp| Contacto</p>
</footer>
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