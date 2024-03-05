@extends('layout.app') <!-- Extiende el layout 'layout.app' -->

@section('title', 'Seneca') <!-- Define el título de la página como 'Seneca' -->

@section('content')

<section class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ trans('integrated.index_page.home') }}</h2>
                            <!-- Muestra el título de la página obtenido de las traducciones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @livewire('index-table') <!-- Incluye el componente Livewire 'index-table' -->
    </div>
    </div>
</section>

<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0">Able Pro © crafted by Aleksander Trujillo, Heriberto Amezcua, Carlos Bernal, Mario Hidalgo, Rúben Megias</p>
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="../index.html">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="../index.html" target="_blank">Cookies policy</a></li>
                    <li class="list-inline-item"><a href="../index.html" target="_blank">Terms and Conditions</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Fin de la sección de contenido -->
@endsection