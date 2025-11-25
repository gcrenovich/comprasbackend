<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcRequerimiento extends Model
{
    protected $table = 'oc_requerimiento';

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_oc',
        'id_requerimiento',
        'observacion',
        'fecha_vinculacion'
    ];

    protected $casts = [
        'id_oc'            => 'integer',
        'id_requerimiento' => 'integer',
        'fecha_vinculacion' => 'datetime',
    ];

    // ============================
    // RELACIONES
    // ============================

    // Cada relación pertenece a una OC
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class, 'id_oc');
    }

    // Cada relación pertenece a un Requerimiento
    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }
}
