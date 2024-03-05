<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profesor;
use App\Models\Leccion;
use App\Models\Grupo;
use App\Models\Modulo;
use App\Models\Formacion;
use Livewire\WithPagination;

class IndexTable extends Component
{
    use WithPagination;

    public Leccion $leccion;
    public $accion = 'Crear';
    public $horas, $leccion_id, $grupo_id, $modulo_id, $profesor_id;

    /**
     * Es un hook de iniciación de la página web con todos los atributos a null, para evitar problemas de iniciación.
     */
    public function mount()
    {
        // Inicializa las propiedades con valores nulos
        $this->horas = null;
        $this->grupo_id = null;
        $this->modulo_id = null;
        $this->profesor_id = null;

        // Inicializa la propiedad $leccion con una nueva instancia de Leccion
        $this->leccion = new Leccion;
    }

    public $perPage = 10; /*Valor por defecto de numeros de usuarios en una tabla*/
    public $search = ''; /*Valor por defecto de la busqueda*/

    public  $sortDirection = 'ASC'; /*Valor por defecto de la dirección de la tabla*/
    public  $sortColumn = 'profesor_nombre'; /*Valor por defecto de la dirección de la tabla*/

    /**
     * Realiza la ordenación de la tabla según la columna especificada.
     *
     * @param string $column Columna por la cual se realizará la ordenación.
     */
    public function doSort($column)
    {
        // Verifica si la columna de ordenación actual es la misma que la nueva
        if ($this->sortColumn === $column) {
            // Cambia la dirección de la ordenación si la dirección actual es 'ASC', de lo contrario, la establece en 'ASC'
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }

        // Establece la nueva columna de ordenación y la dirección como 'ASC'
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }

    // Life cycle hooks
    /**
     * Hook del ciclo de vida: Se ejecuta cuando se actualiza el número de elementos por página.
     * Reinicia la página a la primera cuando se modifica el número de elementos por página.
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }


    /**
     * Hook del ciclo de vida: Se ejecuta cuando se actualiza el término de búsqueda.
     * Reinicia la página a la primera cuando se realiza una nueva búsqueda.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Renderiza la página con todos los datos de lecciones ordenados y paginados.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtiene los datos de lecciones con la búsqueda y ordenación aplicadas, y los paginan según el número especificado por página.
        $lecciones = Leccion::search($this->search)
            ->when($this->sortColumn == 'profesor_nombre', function ($query) {
                // Realiza una join con la tabla profesors y ordena por la columna nombre de profesors
                return $query->join('profesors', 'leccions.profesor_id', '=', 'profesors.id')
                    ->orderBy('profesors.nombre', $this->sortDirection)
                    ->select('leccions.*', 'profesors.nombre as profesor_nombre');
            })
            ->when($this->sortColumn == 'modulo_nombre', function ($query) {
                // Realiza una join con la tabla modulos y ordena por la columna denominacion de modulos
                return $query->join('modulos', 'leccions.modulo_id', '=', 'modulos.id')
                    ->orderBy('modulos.denominacion', $this->sortDirection)
                    ->select('leccions.*', 'modulos.denominacion as modulo_nombre');
            })
            ->when($this->sortColumn == 'grupo_nombre', function ($query) {
                // Realiza una join con la tabla grupos y ordena por la columna denominacion de grupos
                return $query->join('grupos', 'leccions.grupo_id', '=', 'grupos.id')
                    ->orderBy('grupos.denominacion', $this->sortDirection)
                    ->select('leccions.*', 'grupos.denominacion as grupo_nombre');
            })
            ->when($this->sortColumn == 'grupo_year', function ($query) {
                // Realiza una join con la tabla grupos y ordena por la columna curso_escolar de grupos
                return $query->join('grupos', 'leccions.grupo_id', '=', 'grupos.id')
                    ->orderBy('grupos.curso_escolar', $this->sortDirection)
                    ->select('leccions.*', 'grupos.curso_escolar as grupo_year');
            })
            ->when($this->sortColumn == 'formacion_siglas', function ($query) { // Cuando el sortColumn es 'formacion_siglas'
                // Realiza joins con las tablas modulos y formacions y ordena por la columna siglas de formacions
                return $query->join('modulos', 'leccions.modulo_id', '=', 'modulos.id')
                    ->join('formacions', 'modulos.formacion_id', '=', 'formacions.id') // Unir con la tabla formaciones
                    ->orderBy('formacions.siglas', $this->sortDirection) // Ordenar por 'siglas' en la tabla formaciones
                    ->select('leccions.*', 'formacions.siglas as formacion_siglas'); // Seleccionar las siglas de la formación
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        // Obtiene todos los datos de profesores, modulos, grupos y formaciones
        $profesores = Profesor::all();
        $modulos = Modulo::all();
        $grupos = Grupo::all();
        $formaciones = Formacion::all();

        // Retorna la vista 'livewire.index-table' con los datos de lecciones, profesores, modulos, grupos y formaciones paginados.
        return view('livewire.index-table', compact('lecciones', 'profesores', 'modulos', 'grupos', 'formaciones'));
    }

    /**
     * Una función que realiza dos trabajos en uno, depende de que boton pulse en la vista viene con una variable o no,
     * en el caso de que no venga con esta se le inicializa a null.
     *
     * Si esta es null, quiere decir que se va a crear un nuevo registro, en caso de que sea distinto a null es que se va a
     * editar un registro, por lo tanto inicializamos todas nuestras variables con los datos de la BD.
     */
    public function modal($leccion_id = null)
    {
        if ($leccion_id != null) {
            $this->accion = 'Edit';
            $this->leccion = Leccion::findOrFail($leccion_id);
            $this->horas = $this->leccion->horas;
            $this->grupo_id = $this->leccion->grupo_id;
            $this->modulo_id = $this->leccion->modulo_id;
            $this->profesor_id = $this->leccion->profesor_id;
        } else {
            $this->accion = 'Create';
            $this->mount();
        }
    }
    /**
     * Validamos todos los datos que introdujo el usuario por teclado y creamos el nuevo registro, en caso de editar
     * los datos antiguos se conservan en el mismo estado y solo se actualizan los nuevos.
     *
     * Resetamos todas las variables con el hook de renderizado de la web y cerramos la ventana con un scrip.
     */
    public function save()
    {
        $this->validate();

        $leccion = $this->leccion;
        $leccion->horas = $this->horas;
        $leccion->grupo_id = $this->grupo_id;
        $leccion->modulo_id = $this->modulo_id;
        $leccion->profesor_id = $this->profesor_id;

        $leccion->save();
        $this->mount();
        $this->dispatch('cerrar_modal');
    }
    /**
     * Buscamos la lección en función de su id, y la eliminamos.
     */
    public function delete($leccion_id)
    {
        Leccion::find($leccion_id)->delete();
    }


    /**
     * Metodo de validación cuando el usuario hace UPDATE.
     *
     * Se llama con $this->validate(), porque queremos validar los atributos de este componente
     * que son los que el usuario modifica en el form.
     */
    protected $rules = [
        'horas' => [
            'required',
            'integer',
            'min:1',
        ],
        'modulo_id' => [
            'required',
            'integer',
            'min:0'
        ],
        'profesor_id' => [
            'required',
            'integer',
            'min:0'
        ],
        'grupo_id' => [
            'required',
            'integer',
            'min:0'
        ],
    ];
}
