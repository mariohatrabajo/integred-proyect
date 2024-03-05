<div>
    <!-- Modal -->
    <div class="modal fade" id="FormacionModal" tabindex="-1" aria-labelledby="FormacionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="FormacionModalLabel"> {{$accion}} {{ trans('integrated.formations_modal.title') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{!! trans('integrated.formations_modal.close_button') !!}"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="siglas" class="col-form-label"> {{ trans('integrated.formations_modal.acronym_label') }}</label>
                        <input type="text" class="form-control" required wire:model="siglas" id="siglas">
                        <p class="error" id="error_siglas">{{ trans('integrated.formations_modal.acronym_error_message') }}</p>
                        @error('siglas')
                        <p class="error show">{{ trans('integrated.formations_modal.acronym_error_message') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="denominacion" class="col-form-label">{{ trans('integrated.formations_modal.denomination_label') }}</label>
                        <input type="text" class="form-control" required wire:model="denominacion" id="denominacion">
                        <p class="error" id="error_denominacion">{{ trans('integrated.formations_modal.denomination_error_message') }}</p>
                        @error('denominacion')
                        <p class="error show">{{ trans('integrated.formations_modal.denomination_error_message') }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id='cerrar_modal'>{{ trans('integrated.formations_modal.close_button') }}</button>
                    <button type="button" id="insert-submit" class="btn btn-primary" wire:click='save' wire:loading.remove wire:target='save' disabled="true"> {{ $accion }}</button>
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
                                        <label>{{ trans('integrated.formations_modal.show_label') }}&nbsp;
                                            <select name="dom-jqry_length" aria-controls="dom-jqry" class="form-select form-select-sm" wire:model.live="perPage">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp; {{ trans('integrated.formations_modal.entries_label') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="dom-jqry_filter" class="dataTables_filter"><label>{{ trans('integrated.formations_modal.search_label') }}<input type="search" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="" aria-controls="dom-jqry"></label></div>
                                </div>
                            </div>
                            <br>
                            @auth
                            <!-- Verifica si el usuario autenticado tiene el rol con ID 1 -->
                            @if(auth()->user()->roles->contains('id', 1))
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <!-- BOTON VENTANA MODAL -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormacionModal" wire:click='modal()'>
                                        {{ trans('integrated.formations_modal.create_formation_button') }}
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
                        <!-- Verifica si hay formaciones -->
                        @if ($formaciones->isNotEmpty())
                        <table id="new-cons" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="siglas" columnName="{!! trans('integrated.formations_page.formations')  !!}" /></th>
                                    <th wire:click="doSort('denominacion')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="{!! trans('integrated.formations_page.column_denomination')  !!}" /></th>
                                    @auth
                                    <!-- Verifica si el usuario autenticado tiene el rol con ID 1 -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>{{ trans('integrated.formations_page.column_actions') }}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Itera sobre las formaciones -->
                                @foreach ($formaciones as $formacion)
                                <tr>
                                    <td>{{ $formacion->siglas }}</td>
                                    <td>{{ $formacion->denominacion }}</td>
                                    @auth
                                    <!-- Verifica si el usuario autenticado tiene el rol con ID 1 -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <td>
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal" data-bs-target="#FormacionModal" wire:click="modal({{ $formacion->id }})">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <a href="#" onclick="confirm('¿Are you sure?') || event.stopImmediatePropagation()" class="avtar avtar-xs btn-link-danger btn-pc-default" wire:click="delete({{ $formacion->id }})" wire:loading.attr='disable' wire:target='delete'>
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
                        <!-- Verifica si la búsqueda no está vacía y no hay formaciones -->
                        @elseif($formaciones->isEmpty() && $search != '')
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('siglas')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="siglas" columnName="{!! trans('integrated.formations_modal.column_acronym') !!}" /></th>
                                    <th wire:click="doSort('denominacion')" class="column-tables"><x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnNameVar="denominacion" columnName="{!! trans('integrated.formations_modal.column_denomination') !!}" /></th>
                                    </th>
                                    @auth
                                    <!-- Verifica si el usuario autenticado tiene el rol con ID 1 -->
                                    @if(auth()->user()->roles->contains('id', 1))
                                    <th>{{ trans('integrated.formations_page.actions') }}</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">{{ trans('integrated.formations_page.no_results_message') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>{{ trans('integrated.formations_page.no_educations_message') }}</p>
                        @endif
                    </div>
                </div>
                <div class="card-header">
                    <div class="table-responsive dt-responsive">
                        <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="row pagination-center">
                                <div class="col-sm-12 col-md-11">
                                    <!-- Muestra la paginación -->
                                    {{ $formaciones->links() }}
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
    <script type="text/javascript" src="{{asset('js/validations/formacion-validation.js')}}"></script>
</div>