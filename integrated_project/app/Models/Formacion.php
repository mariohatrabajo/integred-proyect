<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formacion extends Model
{
    use HasFactory;


    protected $fillable = [
        'siglas',
        'denominacion'
    ];

    public function modulos(): HasMany
    {
        return $this->hasMany(Modulo::class);
    }

    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class);
    }

    /**
     * Alcance de Eloquent para la búsqueda basada en las columnas "siglas" y "denominacion".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con las columnas "siglas" y "denominacion".
     */
    public function scopeSearch($query, $value)
    {
        // Agrega una cláusula WHERE a la consulta para buscar "siglas" que contengan el valor especificado
        // o "denominacion" que contenga el valor especificado.
        $query->where('siglas', 'like', '%' . $value . '%')
            ->orWhere('denominacion', 'like', '%' . $value . '%');
    }
}
