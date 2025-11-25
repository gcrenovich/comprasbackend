<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    protected $table = 'centro_costo';
    protected $primaryKey = 'id_centro';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'descripcion'
    ];

    // Relaciones
    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class, 'id_centro_costo', 'id_centro');
    }
}
