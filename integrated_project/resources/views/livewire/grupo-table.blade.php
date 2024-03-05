<div>
    <!-- Modal -->
    <div class="modal fade" id="GrupoModal" tabindex="-1" aria-labelledby="GrupoModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="GrupoModalLabel"> {{ $accion }} {{ trans('integrated.groups_modal.group') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="form-group">
                        <label for="denominacion" class="col-form-label"> {{ trans('integrated.groups_modal.label_denomination') }}</label>
                        <input type="text" class="form-control" required wire:model="denominacion" id="denominacion">
                        <p class="error" id="error_denominacion">{{ trans('integrated.groups_modal.invalid_denomination') }}</p>
                        @error('denominacion')
                        <p class="alert alert-danger">{{ trans('integrated.groups_modal.invalid_denomination') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="turno" class="col-form-label">{{ trans('integrated.groups_modal.label_turn') }}</label>
                        <select class="form-control" wire:model="turno" id="turno" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="-1">{{ trans('integrated.groups_modal.select_any_turn') }}</option>
                            <option value="Mañana">{{ trans('integrated.groups_modal.morning') }}</option>
                            <option value="Tarde">{{ trans('integrated.groups_modal.afternoon') }}</option>
                        </select>
                        <p class="error" id="error_turno">{{ trans('integrated.groups_modal.invalid_turn') }}</p>
                        @error('turno')
                        <p class="alert alert-danger">{{ trans('integrated.groups_modal.invalid_turn') }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="curso_escolar" class="col-form-label">{{ trans('integrated.groups_modal.label_school_year') }}</label>
                        <input type="text" class="form-control" required wire:model="curso_escolar" id="curso_escolar">
                        <p class="error" id="error_curso_escolar">{{ trans('integrated.groups_modal.invalid_school_year') }}</p>
                        @error('curso_escolar')
                        <p class="alert alert-danger">{{ trans('integrated.groups_modal.invalid_school_year') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="curso" class="col-form-label">{{ trans('integrated.groups_modal.label_course') }}</label>
                        <select class="form-control" wire:model="curso" id="curso" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="-1">{{ trans('integrated.groups_modal.select_any_course') }}</option>
                            <option value="1">1º</option>
                            <option value="2">2º</option>
                            <option value="3">3º</option>
                            <option value="4">4º</option>
                        </select>
                        <p class="error" id="error_curso">{{ trans('integrated.groups_modal.invalid_course') }}</p>
                        @error('curso')
                        <p class="alert alert-danger">{{ trans('integrated.groups_modal.invalid_course') }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="formacion_id" class="col-form-label">{{ trans('integrated.groups_modal.label_formation') }}</label>
                        <select class="form-control" wire:model="formacion_id" id="formacion" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="-1">{{ trans('integrated.groups_modal.select_any_formation') }}</option>
                            @forelse ($formaciones as $formacion)
                            <option value="{{$formacion->id}}">{{$formacion->denominacion}}</option>
                            @empty
                            <option value=-1>{{ trans('integrated.groups_modal.no_formation_register') }}</option>
                            @endforelse
                        </select>
                        <p class="error" id="error_formacion">{{ trans('integrated.groups_modal.invalid_formation') }}</p>
                        @error('formacion_id')
                        <p class="alert alert-danger">{{ trans('integrated.groups_modal.invalid_formation') }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cerrar_modal'>{{ trans('integrated.groups_modal.close_btn') }}</button>
                    <button type="button" class="btn btn-primary" id="insert-submit" disabled="true" wire:click='save' wire:loading.attr='disable' wire:target='save'> {{ $accion }}</button>
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
                                        <label>{{ trans('integrated.groups_page.show') }}&nbsp;
                                            <select name="dom-jqry_length" aria-controls="dom-jqry" class="form-select form-select-sm" wire:model.live="perPage">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp; {{ trans('integrated.groups_page.entries') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="dom-jqry_filter" class="dataTables_filter"><label>{{ trans('integrated.groups_page.search') }}<input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="" aria-controls="dom-jqry"></label></div>
                                </div>
                            </div>
                            <br>
                            @auth
                            <!-- Si el usuario autenticado tiene el rol de administrador, muestra el botón para añadir un grupo -->
                            @if (auth()->user()->roles->contains('id', 1))
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <!-- BOTON VENTANA MODAL -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#GrupoModal" wire:click='modal()'>
                                        {{ trans('integrated.groups_page.create_group') }}
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
                        <!-- Si hay grupos, muestra la tabla con los grupos -->
                        @if ($grupos->isNotEmpty())

                        <table id="new-cons" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('denominacion')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="{!! trans('integrated.groups_page.denomination') !!}" />
                                    </th>
                                    <th wire:click="doSort('turno')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="turno" columnName="{!! trans('integrated.groups_page.turn') !!}" /></th>
                                    <th wire:click="doSort('curso_escolar')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso_escolar" columnName="{!! trans('integrated.groups_page.school_course') !!}" />
                                    </th>
                                    <th wire:click="doSort('curso')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso" columnName="{!! trans('integrated.groups_page.course') !!}" /></th>
                                    <th wire:click="doSort('formacion_denominacion')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="formacion_denominacion" columnName="{!! trans('integrated.groups_page.formation_denomination') !!}" />
                                    </th>
                                    @auth
                                    <!-- Si el usuario autenticado tiene el rol de administrador, muestra la columna de acciones -->
                                    @if (auth()->user()->roles->contains('id', 1))
                                    <th>  {{ trans('integrated.groups_page.actions') }}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Por cada grupo, muestra una fila con sus datos -->
                                @foreach ($grupos as $grupo)
                                <tr>
                                    <td>
                                        {{ $grupo->denominacion }}
                                    </td>
                                    <td>
                                        {{ $grupo->turno }}
                                    </td>
                                    <td>
                                        {{ $grupo->curso_escolar }}
                                    </td>
                                    <td>
                                        {{ $grupo->curso }}
                                    </td>
                                    <td>
                                        {{ $grupo->formacion->denominacion }}
                                    </td>
                                    @auth
                                    <!-- Si el usuario autenticado tiene el rol de administrador, muestra los botones de editar y eliminar -->
                                    @if (auth()->user()->roles->contains('id', 1))
                                    <td>
                                        <ul class="list-inline me-auto mb-0">

                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal" data-bs-target="#GrupoModal" wire:click="modal({{ $grupo->id }})">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <a href="#" onclick="confirm('¿Are you sure?') || event.stopImmediatePropagation()" class="avtar avtar-xs btn-link-danger btn-pc-default" wire:click="delete({{ $grupo->id }})" wire:loading.attr='disable' wire:target='delete'>
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
                        <!-- Si no hay grupos, muestra un mensaje -->
                        @elseif($grupos->isEmpty() && $search != '')
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('denominacion')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="Denomination" />
                                    </th>
                                    <th wire:click="doSort('turno')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="turno" columnName="Turn" /></th>
                                    <th wire:click="doSort('curso_escolar')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso_escolar" columnName="School course" />
                                    </th>
                                    <th wire:click="doSort('curso')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso" columnName="Course" /></th>
                                    <th wire:click="doSort('formacion_denominacion')" class="column-tables">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="formacion_denominacion" columnName="Formation denomination" />
                                    </th>
                                    @auth
                                    <!-- Si el usuario autenticado tiene el rol de administrador, muestra la columna de acciones -->
                                    @if (auth()->user()->roles->contains('id', 1))
                                    <th>Actions</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">{{ trans('integrated.groups_modal.no_results_found') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>{{ trans('integrated.groups_modal.no_groups_found') }}</p>
                        @endif
                    </div>
                </div>
                <div class="card-header">
                    <div class="table-responsive dt-responsive">
                        <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="row pagination-center">
                                <div class="col-sm-12 col-md-11">
                                    <!-- Muestra la paginación -->
                                    {{ $grupos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('cerrar_modal', event => {
            document.getElementById('cerrar_modal').click();
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/validations/grupo-validation.js') }}"></script>
</div>
