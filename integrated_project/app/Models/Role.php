<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Asignar un rol a un usuario:
     * 1. Obtienes el rol:
     *      $admin = Role::whereName('Admin')->first();
     * 2. Obtienes el usuario:
     *      $usuario = User::whereName('Mario')->first();
     * 3. Usas attach() para asignarle el rol:
     *      $usuario->roles()->attach($admin);
     * 
     * Al usarlo deberías tener en cuenta que no debes asignarle a un usuario un rol que ya tenga.
     * No le metas 10 veces el rol admin al mismo usuario.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    /**
     * Alcance de Eloquent para la búsqueda en la tabla de roles y su relación "users".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con varias columnas.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('roles.name', 'like', '%' . $value . '%')
            ->orWhereHas('users', function ($query) use ($value) {
                $query->where('users.name', 'like', '%' . $value . '%');
            });
    }
}
