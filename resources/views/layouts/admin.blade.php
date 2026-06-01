<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
     <title>@yield('title') |Administracion-Fuerza Urbana</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    @include('components.navbar')

     @yield('content-admin') //Cambair por las paginas que le deben aparecer al admin


</body>
</html>