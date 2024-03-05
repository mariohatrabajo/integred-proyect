<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'siglas',
        'denominacion',
        'curso',
        'especialidad',
        'formacion_id',
        'horas'
    ];

    public function lecciones(): HasMany
    {
        return $this->hasMany(Leccion::class);
    }

    public function formacion(): BelongsTo
    {
        return $this->belongsTo(Formacion::class);
    }

    /**
     * Alcance de Eloquent para la búsqueda en la tabla "modulos" y su relación "formacion".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con varias columnas.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('modulos.curso', 'like', '%' . $value . '%')
            ->orWhere('modulos.especialidad', 'like', '%' . $value . '%')
            ->orWhere('modulos.denominacion', 'like', '%' . $value . '%')
            ->orWhere('modulos.siglas', 'like', '%' . $value . '%')
            ->orWhere('modulos.horas', 'like', '%' . $value . '%')
            ->orWhereHas('formacion', function ($query) use ($value) {
                $query->where('formacions.siglas', 'like', '%' . $value . '%');
            });
    }
}
