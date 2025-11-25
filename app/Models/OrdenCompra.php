<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'orden_compra';
    protected $primaryKey = 'id_oc';
    public $timestamps = false;

    protected $fillable = [
        'numero_oc',
        'fecha',
        'id_proveedor',
        'observacion',
        'archivo_oc_path'
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function requerimientos()
    {
        return $this->belongsToMany(
            Requerimiento::class,
            'oc_requerimiento',
            'id_oc',
            'id_requerimiento'
        );
    }
}
