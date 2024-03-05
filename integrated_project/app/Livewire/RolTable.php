<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;

class RolTable extends Component
{

    use WithPagination;
    public $accion = 'Edit';
    public $notificacion;
    public $nombre_usuario, $id_usuario, $rol;
    public User $usuario;
    public $roles;

    /**
     * Hook de iniciación al renderizar la página en el cual inicalizamos todas las variables
     */
    public function mount()
    {
        // Inicializa las propiedades con valores nulos
        $this->nombre_usuario = null;
        $this->notificacion = null;
        $this->rol = null;
        // Inicializa la propiedad $usuario con una nueva instancia de User
        $this->usuario = new User;
        // Obtiene todos los roles disponibles
        $this->roles = Role::all();
    }

    // Propiedades públicas con valores por defecto
    public $perPage = 10; /*Valor por defecto de numeros de usuarios en una tabla*/
    public $search = ''; /*Valor por defecto de la busqueda*/

    public  $sortDirection = 'ASC'; /*Valor por defecto de la dirección de la tabla*/
    public  $sortColumn = 'name'; /*Valor por defecto de la dirección de la tabla*/

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
     * Renderiza la página con todos los datos de usuarios ordenados y paginados.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtiene los datos de usuarios con la búsqueda y ordenación aplicadas, y los paginan según el número especificado por página.
        $usuarios = User::search($this->search)
            ->when($this->sortColumn == 'user_name', function ($query) {
                // Ordena por la columna 'name' en la tabla 'users'
                return $query->orderBy('name', $this->sortDirection);
            })
            ->when($this->sortColumn == 'role_name', function ($query) {
                // Realiza joins con las tablas 'role_user' y 'roles', y ordena por la columna 'name' en la tabla 'roles'
                return $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->orderBy('roles.name', $this->sortDirection)
                    ->select('users.*', 'roles.name as role_name');
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        // Obtiene todos los datos de roles disponibles
        $roles = Role::all();

        // Retorna la vista 'livewire.rol-table' con los datos de usuarios y roles paginados.
        return view('livewire.rol-table', compact('usuarios', 'roles'));
    }

    /**
     *  Recogemos el id del usuario al que quiere editar el rango, lo buscamos en la base de datos y rellenamos las variables
     *  con los datos de este.
     */
    public function modal($usuario_id)
    {

        $this->usuario = User::findOrFail($usuario_id);
        $this->nombre_usuario = $this->usuario->name;
        $this->id_usuario = $this->usuario->id;
    }
    /**
     *  Boton SAVE de la ventana modal
     *
     *  1.Comprobamos que el nuevo rol que le queremos asignar al usuario no lo tenga, en caso de tenerlo le mostramos un
     *  mensaje diciendole que no puede asignar el mismo rol mas de una vez, en caso contrario se lo asigna.
     */
    public function save()
    {
        $this->validate();

        if (!$this->usuario->roles()->where('role_id', $this->rol)->exists()) {
            // Si no existe, asignar el rol
            $this->usuario->roles()->attach($this->rol);
            $this->mount();
        } else {
            $this->notificacion = 'This user already has that role assigned';
        }


        $this->dispatch('cerrar_modal');
    }

    public function delete($usuario_id)
    {

        $usuario = User::findOrFail($usuario_id);

        if ($usuario->roles()->where('role_id', 1)->exists()) {

            $usuario->roles()->detach(1);
        }
    }

    /**
     * Variable de validación que usa el metodo validate()
     */
    protected $rules = [
        'id_usuario' => [
            'required',
            'integer',
            'min:0'
        ],
        'rol' => [
            'required',
            'integer',
            'min:0',
        ]
    ];
}
