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
            <a href="/Login" class="btn btn-outline-danger rounded-pill fw-bold" style="padding: 4px 15px; font-size: 12px; letter-spacing: 0.5px; line-height: 1.2;">
    LOGIN
</a>

<a href="/Register" class="btn btn-light rounded-pill fw-bold text-black ms-2" style="padding: 4px 15px; font-size: 12px; letter-spacing: 0.5px; line-height: 1.2;">
    REGISTER
</a>
</div>
        </div>
    </nav>
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