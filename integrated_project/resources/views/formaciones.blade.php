@extends('layout.app') <!-- Extiende el layout 'layout.app' -->

@section('title', 'Education') <!-- Define el título de la página como 'Education' -->

@section('content') <!-- Comienza la sección de contenido -->
<section class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ trans('integrated.formations_page.formations')}}</h2>
                            <!-- Muestra el título de la página obtenido de las traducciones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @livewire('formacion-table') <!-- Incluye el componente Livewire 'formacion-table' -->
    </div>
</section>
<!-- Fin de la sección de contenido -->
@endsection