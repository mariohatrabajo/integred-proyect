<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'denominacion',
        'turno',
        'curso_escolar',
        'curso',
        'formacion_id',
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
     * Alcance de Eloquent para la búsqueda en la tabla "grupos" y su relación "formacion".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value El valor de búsqueda para comparar con varias columnas.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('grupos.denominacion', 'like', '%' . $value . '%')
            ->orWhere('grupos.turno', 'like', '%' . $value . '%')
            ->orWhere('grupos.curso_escolar', 'like', '%' . $value . '%')
            ->orWhere('grupos.curso', 'like', '%' . $value . '%')
            ->orWhereHas('formacion', function ($query) use ($value) {
                $query->where('formacions.denominacion', 'like', '%' . $value . '%');
            });
    }
}
