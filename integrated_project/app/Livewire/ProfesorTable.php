<?php

namespace App\Livewire;

use App\Models\Profesor;
use Livewire\Component;
use Livewire\WithPagination;

class ProfesorTable extends Component
{

    use WithPagination;

    public $accion = 'Create';
    public Profesor $profesor;

    public $nombre, $apellido1, $apellido2, $especialidad, $usu_seneca;
    public $error;

    /**
     * Es un hook de iniciación de la página web con todos los atributos a null, para evitar problemas de iniciación.
     */
    public function mount()
    {
        $this->usu_seneca = null;
        $this->nombre = null;
        $this->apellido1 = null;
        $this->apellido2 = null;
        $this->especialidad = null;
        $this->profesor = new Profesor;
    }

    public $perPage = 10; /*Valor por defecto de numeros de usuarios en una tabla*/
    public $search = ''; /*Valor por defecto de la busqueda*/

    public  $sortDirection = 'ASC'; /*Valor por defecto de la dirección de la tabla*/
    public  $sortColumn = 'usu_seneca'; /*Valor por defecto de la dirección de la tabla*/

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
     * Renderiza la página con todos los datos de profesores ordenados y paginados.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // $teachers = Profesor::where('nombre', 'like', '%' . $this->search . '%')
        //     ->orWhere('apellido1', 'like', '%' . $this->search . '%')
        //     ->orWhere('apellido2', 'like', '%' . $this->search . '%')
        //     ->orWhere('usu_seneca', 'like', '%' . $this->search . '%')
        //     ->orWhere('especialidad', 'like', '%' . $this->search . '%')
        //     ->get();

        // Obtiene los datos de profesores con la búsqueda y ordenación aplicadas, y los paginan según el número especificado por página.
        $teachers = Profesor::search($this->search)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        // Retorna la vista 'livewire.profesor-table' con los datos de profesores paginados.
        return view('livewire.profesor-table', compact('teachers'));
    }

    /**
     * Una función que realiza dos trabajos en uno, depende de que boton pulse en la vista viene con una variable o no,
     * en el caso de que no venga con esta se le inicializa a null.
     *
     * Si esta es null, quiere decir que se va a crear un nuevo registro, en caso de que sea distinto a null es que se va a
     * editar un registro, por lo tanto inicializamos todas nuestras variables con los datos de la BD.
     */
    public function modal($profesor_id = null)
    {
        if ($profesor_id != null) {
            $this->accion = 'Edit';

            $this->profesor = Profesor::findOrFail($profesor_id);
            $this->usu_seneca = $this->profesor->usu_seneca;
            $this->nombre = $this->profesor->nombre;
            $this->apellido1 = $this->profesor->apellido1;
            $this->apellido2 = $this->profesor->apellido2;
            $this->especialidad = $this->profesor->especialidad;
        } else {
            $this->accion = 'Create';

            $profesor = $this->profesor;
            $profesor->usu_seneca = $this->usu_seneca;
            $profesor->nombre = $this->nombre;
            $profesor->apellido1 = $this->apellido1;
            $profesor->apellido2 = $this->apellido2;
            $profesor->especialidad = $this->especialidad;
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
        $this->validate($this->rules());

        $profesor = $this->profesor;
        $profesor->usu_seneca = $this->usu_seneca;
        $profesor->nombre = $this->nombre;
        $profesor->apellido1 = $this->apellido1;
        $profesor->apellido2 = $this->apellido2;
        $profesor->especialidad = $this->especialidad;

        $profesor->save();
        $this->mount();
        $this->dispatch('cerrar_modal');
    }

    /**
     * Sacamos el objeto profesor en función del ID, una vez hecho eso por la relacion 1 a N
     * sacamos todas las lecciones que tiene ese grupo y si la variable lecciones es distinta de null
     * las recorremos una a una y las vamos borrando, una vez eliminado todo eliminamos el profesor.
     */
    public function delete($profesor_id)
    {
        $profesor = Profesor::findOrFail($profesor_id);
        $lecciones = $profesor->lecciones;
        if ($lecciones != null) {
            foreach ($lecciones as $leccion) {
                $leccion->delete();
            }
        }
        $profesor->delete();
    }


    /**
     * Metodo de validación cuando el usuario hace UPDATE.
     *
     * Se llama con $this->validate(), porque queremos validar los atributos de este componente
     * que son los que el usuario modifica en el form.
     */
    public function rules()
    {
        return [
            'usu_seneca' => [
                'required',
            ],
            'nombre' => [
                'required',
                'max:30',
                'min:3',
                'alpha:ascii',
            ],
            'apellido1' => [
                'required',
                'max:50',
                'min:3',
                'alpha:ascii',
            ],
            'apellido2' => [
                'required',
                'max:50',
                'min:3',
                'alpha:ascii',
            ],
            'especialidad' => [
                'required',
                'regex:/^(secundaria|formacion profesional)$/i',
            ],
        ];
    }
}
