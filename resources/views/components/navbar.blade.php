<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<nav class="navbar navbar-expand-lg navbar-dark bg-black shadow" style="position:sticky;top:0;z-index:1000;transition:top .3s">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger" href="/Principal">
            <img src="/img/logo.png" alt="Fuerza Urbana" height="60">
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="menu" class="collapse navbar-collapse justify-content-end">
            <div class="navbar-nav me-3">
                <a class="nav-link" href="/Principal">Inicio</a>
                <a class="nav-link" href="/Quienes-somos">Quiénes somos</a>
                <a class="nav-link" href="/Comercializacion">Comercialización</a>
                <a class="nav-link" href="/Informacion-de-contacto">Contacto</a>
                <a class="nav-link" href="/Terminos-y-usos">Términos</a>
                <a class="nav-link" href="/Catalogos-de-productos">Catálogo</a>
            </div>

            <div class="d-flex align-items-center gap-2">

                {{-- CARRITO --}}
                <a href="/Carrito" class="btn btn-outline-danger btn-sm position-relative">
                    <i class="bi bi-cart3"></i>
                    @php $cantCarrito = session('carrito') ? count(session('carrito')) : 0 @endphp
                    @if($cantCarrito > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size:.6rem">{{ $cantCarrito }}</span>
                    @endif
                </a>

                @guest
                    <a href="/Login" class="btn btn-outline-danger rounded-pill fw-bold"
                       style="padding:4px 15px;font-size:12px">LOGIN</a>
                    <a href="/Register" class="btn btn-light rounded-pill fw-bold text-black"
                       style="padding:4px 15px;font-size:12px">REGISTER</a>
                @endguest

                @auth
                    {{-- DROPDOWN USUARIO --}}
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">
                            <span class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                                  style="width:32px;height:32px;font-size:.75rem;font-weight:700">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </span>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="/Mis-compras">
                                    <i class="bi bi-box-seam me-2"></i>Mis compras
                                </a>
                            </li>
                            @if(Auth::user()->role === 'admin')
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="/admin">
                                    <i class="bi bi-speedometer2 me-2"></i>Panel Admin
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
let lastScroll = 0;
const navbar = document.querySelector(".navbar");
window.addEventListener("scroll", function() {
    let currentScroll = window.pageYOffset;
    navbar.style.top = currentScroll > lastScroll && currentScroll > 80 ? "-80px" : "0";
    lastScroll = currentScroll;
});
</script>