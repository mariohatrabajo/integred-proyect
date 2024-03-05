<div>
    <!-- Modal -->
    <div class="modal fade" id="ModuloModal" tabindex="-1" aria-labelledby="ModuloModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModuloModalLabel"> {{$accion}} {{trans('integrated.modules_modal.module')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id='cerrar_modal'></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="denominacion" class="col-form-label">{{trans('integrated.modules_modal.label_denomination')}}</label>
                        <input type="text" class="form-control" required wire:model="denominacion" id="denominacion">
                        <p class="error" id="error_denominacion">{{trans('integrated.modules_modal.invalid_denomination')}}</p>
                        @error('denominacion')
                        <p class="error show">{{trans('integrated.modules_modal.invalid_denomination')}}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="especialidad" class="col-form-label">{{trans('integrated.modules_modal.label_speciality')}}</label>
                        <select class="form-control" wire:model="especialidad" id="especialidad" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="null">{{trans('integrated.modules_modal.select_speciality')}}</option>
                            <option value="secundaria">{{trans('integrated.modules_modal.high_school')}}</option>
                            <option value="formacion profesional">{{trans('integrated.modules_modal.vocational_training')}}</option>
                        </select>
                        <p class="error" id="error_especialidad">{{trans('integrated.modules_modal.error_speciality')}}</p>
                        @error('especialidad')
                        <p class="error show">{{trans('integrated.modules_modal.error_speciality')}}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="siglas" class="col-form-label">{{trans('integrated.modules_modal.label_acronym')}}</label>
                        <input type="text" class="form-control" required wire:model="siglas" id="siglas">
                        <p class="error" id="error_siglas">{{trans('integrated.modules_modal.invalid_acronym')}}</p>
                        @error('siglas')
                        <p class="error show">{{trans('integrated.modules_modal.invalid_acronym')}}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="curso" class="col-form-label">{{trans('integrated.modules_modal.label_course')}}</label>
                        <select class="form-control" wire:model="curso" id="curso" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="-1">{{trans('integrated.modules_modal.select_course')}}</option>
                            <option value='1'>1º</option>
                            <option value='2'>2º</option>
                            <option value='3'>3º</option>
                            <option value='4'>4º</option>
                        </select>
                        <p class="error" id="error_curso">{{trans('integrated.modules_modal.error_course')}}</p>
                        @error('curso')
                        <p class="error show">{{trans('integrated.modules_modal.error_course')}}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="horas" class="col-form-label">{{trans('integrated.modules_modal.label_hours')}}</label>
                        <input type="number" class="form-control" required wire:model="horas" id="horas">
                        <p class="error" id="error_horas">{{trans('integrated.modules_modal.invalid_hours')}}</p>
                        @error('horas')
                        <p class="error show">{{trans('integrated.modules_modal.invalid_hours')}}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="formacion_id" class="col-form-label">{{ trans('integrated.groups_modal.label_formation') }}</label>
                        <select class="form-control" wire:model="formacion_id" id="formacion" required="" aria-describedby="bouncer-error_select" aria-invalid="true">
                            <option value="-1">{{trans('integrated.modules_modal.select_formation')}}</option>
                            @forelse ($formaciones as $formacion)
                            <option value='{{ $formacion->id }}'>{{$formacion->denominacion}}</option>
                            @empty
                            <option value="-1">{{trans('integrated.modules_modal.no_formation_registered')}}</option>
                            @endforelse
                        </select>
                        <p class="error" id="error_formacion">{{trans('integrated.modules_modal.error_formation')}}</p>
                        @error('formacion_id')
                        <p class="error show">{{trans('integrated.modules_modal.error_formation')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cerrar_modal'>{{trans('integrated.modules_modal.close_btn')}}</button>
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
                                        <label>{{trans('integrated.modules_page.show')}}&nbsp;
                                            <select name="dom-jqry_length" aria-controls="dom-jqry" class="form-select form-select-sm" wire:model.live="perPage">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp; {{trans('integrated.modules_page.entries')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="dom-jqry_filter" class="dataTables_filter"><label>{{trans('integrated.modules_page.label_search')}}<input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="" aria-controls="dom-jqry"></label></div>
                                </div>
                            </div>
                            <br>
                            @auth
                            <!-- comprobamos si el usuario tiene el rol de administrador -->
                            @if(auth()->user()->roles->contains('id', 1))
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <!-- BOTON VENTANA MODAL -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModuloModal" wire:click='modal()'>
                                        {{trans('integrated.modules_page.create_module')}}
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
                        <!-- Si hay módulos -->
                        @if ($modulos->isNotEmpty())
                        <table id="new-cons" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('denominacion')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="{!! trans('integrated.modules_page.denomination')!!}" /></th>
                                    <th wire:click="doSort('especialidad')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="especialidad" columnName="{!! trans('integrated.modules_page.speciality')!!}" /></th>
                                    <th wire:click="doSort('siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="siglas" columnName="{!! trans('integrated.modules_page.acronym')!!}" /></th>
                                    <th wire:click="doSort('curso')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso" columnName="{!! trans('integrated.modules_page.course')!!}" /></th>
                                    <th wire:click="doSort('horas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="horas" columnName="{!! trans('integrated.modules_page.hours')!!}" /></th>
                                    <th wire:click="doSort('formacion_siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="formacion_siglas" columnName="{!! trans('integrated.modules_page.formation')!!}" /></th>
                                    @auth
                                    <!-- comprobamos si el usuario tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>   {{trans('integrated.modules_page.actions')}}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Recorremos los módulos -->
                                @foreach ($modulos as $modulo)
                                <tr>
                                    <td>{{ $modulo->denominacion }}</td>
                                    <td>{{ $modulo->especialidad }}</td>
                                    <td>{{ $modulo->siglas }}</td>
                                    <td>{{ $modulo->curso }}</td>
                                    <td>{{ $modulo->horas }}</td>
                                    <td>{{ $modulo->formacion->siglas}}</td>
                                    @auth
                                    <!-- comprobamos si el usuario tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <td>
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal" data-bs-target="#ModuloModal" wire:click="modal({{ $modulo->id }})">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <a href="#" onclick="confirm('¿Are you sure?') || event.stopImmediatePropagation()" class="avtar avtar-xs btn-link-danger btn-pc-default" wire:click="delete({{ $modulo->id }})" wire:loading.attr='disable' wire:target='delete'>
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
                        <!-- Si no hay módulos -->
                        @elseif($modulos->isEmpty() && $search != '')
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('denominacion')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="Denomination" /></th>
                                    <th wire:click="doSort('especialidad')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="especialidad" columnName="Speciality" /></th>
                                    <th wire:click="doSort('siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="siglas" columnName="Acronym" /></th>
                                    <th wire:click="doSort('curso')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="curso" columnName="Cours" /></th>
                                    <th wire:click="doSort('horas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="horas" columnName="Hours" /></th>
                                    <th wire:click="doSort('formacion_siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="formacion_siglas" columnName="Formation" /></th>
                                    @auth
                                    <!-- comprobamos si el usuario tiene el rol de administrador -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>Actions</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">  {{trans('integrated.modules_page.no_results_found')}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>  {{trans('integrated.modules_page.no_modules_found')}}</p>
                        @endif
                    </div>
                </div>
                <div class="card-header">
                    <div class="table-responsive dt-responsive">
                        <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="row pagination-center">
                                <div class="col-sm-12 col-md-11">
                                    <!-- Paginación -->
                                    {{$modulos->links()}}
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
    <script type="text/javascript" src="{{asset('js/validations/modulo-validation.js')}}"></script>
</div>
