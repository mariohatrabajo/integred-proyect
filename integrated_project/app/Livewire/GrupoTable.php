<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Formacion;
use App\Models\Leccion;
use Livewire\WithPagination;


class GrupoTable extends Component
{
    use WithPagination;

    public $accion = 'Crear';
    public Grupo $grupo;
    public $grupo_id, $denominacion, $turno, $curso_escolar, $curso, $formacion_id;


    /**
     * Es un hook de iniciación de la página web con todos los atributos a null, para evitar problemas de iniciación.
     */
    public function mount()
    {
        // Inicializa las propiedades con valores nulos
        $this->grupo_id = null;
        $this->denominacion = null;
        $this->curso_escolar = null;
        $this->curso = null;
        $this->formacion_id = null;
        $this->turno = null;

        // Inicializa la propiedad $grupo con una nueva instancia de Grupo
        $this->grupo = new Grupo;
    }

    public $perPage = 10; /*Valor por defecto de numeros de usuarios en una tabla*/
    public $search = ''; /*Valor por defecto de la busqueda*/

    public  $sortDirection = 'ASC'; /*Valor por defecto de la dirección de la tabla*/
    public  $sortColumn = 'denominacion'; /*Valor por defecto de la dirección de la tabla*/

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
     * Renderiza la página con todos los datos de grupos ordenados y paginados.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtiene los datos de grupos con la búsqueda y ordenación aplicadas, y los paginan según el número especificado por página.
        $grupos = Grupo::search($this->search)
            ->when($this->sortColumn == 'formacion_denominacion', function ($query) {
                // Realiza una join con la tabla formacions y ordena por la columna denominacion de formacions
                return $query->join('formacions', 'grupos.formacion_id', '=', 'formacions.id')
                    ->orderBy('formacions.denominacion', $this->sortDirection)
                    ->select('grupos.*', 'formacions.denominacion as formacion_denominacion'); // Cambia el nombre de la columna siglas de la tabla formaciones
            }, function ($query) {
                // Ordena directamente por la columna y dirección especificadas
                return $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
        // Obtiene todos los datos de formaciones
        $formaciones = Formacion::all();

        // Retorna la vista 'livewire.grupo-table' con los datos de grupos y formaciones paginados.
        return view('livewire.grupo-table', compact('grupos', 'formaciones'));
    }

    /**
     * Una función que realiza dos trabajos en uno, depende de que boton pulse en la vista viene con una variable o no,
     * en el caso de que no venga con esta se le inicializa a null.
     *
     * Si esta es null, quiere decir que se va a crear un nuevo registro, en caso de que sea distinto a null es que se va a
     * editar un registro, por lo tanto inicializamos todas nuestras variables con los datos de la BD.
     */
    public function modal($grupo_id = null)
    {
        if ($grupo_id != null) {
            $this->accion = 'Edit';

            $this->grupo = Grupo::findOrFail($grupo_id);
            $this->denominacion = $this->grupo->denominacion;
            $this->curso_escolar = $this->grupo->curso_escolar;
            $this->curso = $this->grupo->curso;
            $this->formacion_id = $this->grupo->formacion_id;
            $this->turno = $this->grupo->turno;
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

        $grupo = $this->grupo;

        $grupo->denominacion = $this->denominacion;
        $grupo->curso_escolar = $this->curso_escolar;
        $grupo->curso = $this->curso;
        $grupo->formacion_id = $this->formacion_id;
        $grupo->turno = $this->turno;

        $grupo->save();

        $this->mount();

        $this->dispatch('cerrar_modal');
    }

    /**
     * Sacamos el objeto grupo en función del ID, una vez hecho eso por la relacion 1 a N
     * sacamos todas las lecciones que tiene ese grupo y si la variable lecciones es distinta de null
     * las recorremos una a una y las vamos borrando, una vez eliminado todo eliminamos el grupo.
     *
     */
    public function delete($grupo_id)
    {

        $grupo = Grupo::find($grupo_id);
        $lecciones = $grupo->lecciones;
        if ($lecciones != null) {
            foreach ($lecciones as $leccion) {
                $leccion->delete();
            }
        }
        $grupo->delete();
    }



    /**
     * Metodo de validación cuando el usuario hace UPDATE.
     *
     * Se llama con $this->validate(), porque queremos validar los atributos de este componente
     * que son los que el usuario modifica en el form.
     */
    protected $rules = [
        'denominacion' => [
            'required',
            'max:255',
            'min:3'
        ],
        'curso_escolar' => [
            'required',
            'regex:/^\d{4}\/\d{4}$/i',
        ],
        'curso' => [
            'required',
        ],
        'turno' => [
            'required',
            'regex:/^(Mañana|Tarde)$/i'
        ],
        'formacion_id' => [
            'required',
            'integer',
            'min:0'
        ],
    ];
}
