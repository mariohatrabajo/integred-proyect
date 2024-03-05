@extends('layout.app') <!-- Extiende el layout 'layout.app' -->

@section('title', 'Groups') <!-- Define el título de la página como 'Groups' -->

@section('content')
<section class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ trans('integrated.groups_page.groups') }}</h2>
                            <!-- Muestra el título de la página obtenido de las traducciones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @livewire('grupo-table') <!-- Incluye el componente Livewire 'grupo-table' -->
    </div>
</section>
<!-- Fin de la sección de contenido -->
@endsection