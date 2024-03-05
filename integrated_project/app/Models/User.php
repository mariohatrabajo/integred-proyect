<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Alcance de Eloquent para la búsqueda en la tabla de usuarios y su relación "roles".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con las columnas.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('users.name', 'like', '%' . $value . '%')
            ->orWhereHas('roles', function ($query) use ($value) {
                $query->where('roles.name', 'like', '%' . $value . '%');
            });
    }
}
