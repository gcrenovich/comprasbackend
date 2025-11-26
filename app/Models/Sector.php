<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectores';
    protected $primaryKey = 'id_sector';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // ===============================
    // RELACIONES
    // ===============================

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_sector', 'id_sector');
    }

    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class, 'id_sector', 'id_sector');
    }

    // ===============================
    // MÉTODOS ÚTILES
    // ===============================
    public function __toString()
    {
        return $this->nombre;
    }
}
