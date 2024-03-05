<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'horas',
        'profesor_id',
        'modulo_id',
        'grupo_id'
    ];

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class);
    }

    public function Modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class);
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    /**
     * Alcance de Eloquent para la búsqueda en la tabla "leccions" y sus relaciones asociadas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con varias columnas.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('leccions.horas', 'like', '%' . $value . '%')
            ->orWhereHas('profesor', function ($query) use ($value) {
                // Utiliza una cláusula WHERE para buscar en la relación "profesor" basada en la columna "nombre".
                $query->where('profesors.nombre', 'like', '%' . $value . '%');
            })
            ->orWhereHas('modulo', function ($query) use ($value) {
                // Utiliza una cláusula WHERE para buscar en la relación "modulo" basada en la columna "denominacion".
                $query->where('modulos.denominacion', 'like', '%' . $value . '%');
            })
            ->orWhereHas('grupo', function ($query) use ($value) {
                // Utiliza una cláusula WHERE para buscar en la relación "grupo" basada en la columna "denominacion".
                $query->where('grupos.denominacion', 'like', '%' . $value . '%');
            });
    }
}
