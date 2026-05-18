@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')

    <section class="hero text-center d-flex align-items-center">
        <div class="container">
            <h1 class="fw-bold display-5">Catálogo Deportivo</h1>
            <p class="lead">Equipate con lo mejor en rendimiento y estilo</p>
        </div>
    </section>


    <section class="container mt-5" id="productos">
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
   @endsection