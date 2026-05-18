@extends('layouts.app')

@section('title', 'Contacto')

@section('content')


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

  @endsection  