<div>
    <!-- Modal -->
    <div class="modal fade" id="FormacionModal" tabindex="-1" aria-labelledby="FormacionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="FormacionModalLabel"> {{ $accion }} {{ trans('integrated.teachers_modal.teacher')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usu_seneca" class="col-form-label">{{ trans('integrated.teachers_modal.seneca_user')}}</label>
                        <input type="text" class="form-control" required wire:model="usu_seneca" id="usu_seneca">
                        <p class="error" id="error_usu_seneca">{{ trans('integrated.teachers_modal.seneca_user_error_message')}}</p>
                        @error('usu_seneca')
                        <p class="error show">
                            {{ trans('integrated.teachers_modal.seneca_user_error_invalid')}}
                        </p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="nombre" class="col-form-label">       {{ trans('integrated.teachers_modal.name')}}</label>
                        <input type="text" class="form-control" required wire:model="nombre" id="nombre">
                        <p class="error" id="error_nombre">   {{ trans('integrated.teachers_modal.name_error_message')}}</p>
                        @error('name')
                        <p class="error show"> {{ trans('integrated.teachers_modal.name_error_message')}}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="" class="col-form-label">{{ trans('integrated.teachers_modal.last_name')}}</label>
                        <input type="text" class="form-control" required wire:model="apellido1" id="apellido1">
                        @error('apellido1')
                        <p class="error show">
                            {{ trans('integrated.teachers_modal.first_last_name_error_invalid')}}
                        </p>
                        @enderror
                        <br>
                        <input type="text" class="form-control" required wire:model="apellido2" id="apellido2">
                        @error('apellido2')
                        <p class="error show">
                            {{ trans('integrated.teachers_modal.second_last_name_error_invalid')}}

                        </p>
                        @enderror
                        <p class="error" id="error_apellidos"> {{ trans('integrated.teachers_modal.last_name_error_message')}}</p>
                    </div>

                    <div class="form-group">
                        <label for="speciality" class="col-form-label"> {{ trans('integrated.teachers_modal.speciality')}}</label>
                        <select class="form-control" wire:model="especialidad" id="speciality" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="null">{{ trans('integrated.teachers_modal.select_speciality_option')}}</option>
                            <option value="secundaria">{{ trans('integrated.teachers_modal.high_school_option')}}</option>
                            <option value="formacion profesional">{{ trans('integrated.teachers_modal.vocational_training_option')}}</option>
                        </select>
                        <p class="error" id="error_speciality">{{ trans('integrated.teachers_modal.select_speciality_message')}}</p>
                        @error('especialidad')
                        <p class="error show">{{ trans('integrated.teachers_modal.select_speciality_message')}}</p>
                        @enderror
                    </div>
                </div>
                <br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cerrar_modal'>{{ trans('integrated.teachers_modal.close_button')}}</button>
                    <button type="button" class="btn btn-primary" id="insert-submit" wire:click='save' wire:loading.attr='disable' wire:target='save' disabled="true"> {{ $accion }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- DOM/Jquery table start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive dt-responsive">
                        <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="dom-jqry_length">
                                        <label>{{ trans('integrated.teachers_modal.show_label')}}&nbsp;
                                            <select name="dom-jqry_length" aria-controls="dom-jqry" class="form-select form-select-sm" wire:model.live="perPage">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp; {{ trans('integrated.teachers_modal.entries_label')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="dom-jqry_filter" class="dataTables_filter"><label> {{ trans('integrated.teachers_modal.search_label')}}<input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="" aria-controls="dom-jqry"></label></div>
                                </div>
                            </div>
                            <br>
                            @auth
                            <!-- Comprueba si el usuario autenticado tiene el rol de administrador -->
                            @if(auth()->user()->roles->contains('id', 1))
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <!-- BOTON VENTANA MODAL -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormacionModal" wire:click='modal()'>
                                        {{ trans('integrated.teachers_modal.create_teacher_button')}}
                                    </button>
                                </div>
                            </div>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dt-responsive">
                        <!-- Comprueba si la colección de profesores no está vacía -->
                        @if ($teachers->isNotEmpty())
                        <table id="new-cons" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('usu_seneca')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="usu_seneca" columnName="{!! trans('integrated.teachers_page.column_seneca_user') !!}" /></th>
                                    <th wire:click="doSort('nombre')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="nombre" columnName="{!! trans('integrated.teachers_page.column_name') !!}" /></th>
                                    <th wire:click="doSort('apellido1')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="apellido1" columnName="{!! trans('integrated.teachers_page.column_first_name') !!}" /></th>
                                    <th wire:click="doSort('apellido2')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="apellido2" columnName="{!! trans('integrated.teachers_page.column_last_name') !!}" /></th>
                                    <th wire:click="doSort('especialidad')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="especialidad" columnName="{!! trans('integrated.teachers_page.column_speciality') !!}" /></th>
                                    @auth
                                    <!-- Comprueba si el usuario autenticado tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>{{ trans('integrated.teachers_modal.actions_header')}}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Recorre la colección de profesores -->
                                @foreach ($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->usu_seneca }}</td>
                                    <td>{{ $teacher->nombre }}</td>
                                    <td>{{ $teacher->apellido1 }}</td>
                                    <td>{{ $teacher->apellido2 }}</td>
                                    <td>{{ $teacher->especialidad }}</td>
                                    @auth
                                    <!-- Comprueba si el usuario autenticado tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <td>
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal" data-bs-target="#FormacionModal" wire:click="modal({{ $teacher->id }})">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <a href="#"  class="avtar avtar-xs btn-link-danger btn-pc-default" wire:click="delete({{ $teacher->id }})" wire:loading.attr='disable' wire:target='delete' onclick="confirm('¿Are you sure?') || event.stopImmediatePropagation()">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    @endif
                                    @endauth
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Comprueba si la colección de profesores está vacía y si la variable de búsqueda no está vacía -->
                        @elseif($teachers->isEmpty() && $search != '')
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                            <th wire:click="doSort('usu_seneca')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="usu_seneca" columnName="Seneca User" /></th>
                                    <th wire:click="doSort('nombre')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="nombre" columnName="Name" /></th>
                                    <th wire:click="doSort('apellido1')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="apellido1" columnName="First Name" /></th>
                                    <th wire:click="doSort('apellido2')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="apellido2" columnName="Last Name" /></th>
                                    <th wire:click="doSort('especialidad')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="especialidad" columnName="Speciality" /></th>
                                    </th>
                                    @auth
                                    <!-- Comprueba si el usuario autenticado tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>{{ trans('integrated.teachers_modal.actions_header')}}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">{{ trans('integrated.teachers_modal.no_results_message')}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>{{ trans('integrated.teachers_modal.no_teachers_message')}}</p>
                        @endif
                    </div>
                </div>
                <div class="card-header">
                    <div class="table-responsive dt-responsive">
                        <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="row pagination-center">
                                <div class="col-sm-12 col-md-11">
                                    <!-- Muestra la paginación de la colección de profesores -->
                                    {{ $teachers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
        AÑADIRLO A UN JS Y LINKEARLO NO DEJAR LA CHAPUZA ESTA
    -->
    <script>
        window.addEventListener('cerrar_modal', event => {
            document.getElementById('cerrar_modal').click();
        });
    </script>
    <script type="text/javascript" src="{{asset('js/validations/profesor-validation.js')}}"></script>
</div>
