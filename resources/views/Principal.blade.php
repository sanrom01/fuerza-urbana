<!DOCTYPE html>
<html>
<head>
<title>Principal</title>
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
 <div class="container">
 <a class="navbar-brand" href="#">Fuerza Urbana</a>
 <div class="navbar-nav">
 <a class="nav-link" href="/Principal">Inicio</a>
 <a class="nav-link active" href="/Quienes-somos">Quienes somos</a>
 <a class="nav-link active" href="/Comercializacion">Comercializacion</a>
 <a class="nav-link active" href="/Informacion-de-contactos">Contacto</a>
 <a class="nav-link active" href="/Terminos-y-usos">Terminos y usos</a>
 <a class="nav-link active" href="/Catalogos-de-productos">Catalogo</a>
 </div>
 </div>
</nav>

 <section class="hero text-center text-white py-5">
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

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>