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

    // == RELACIONES ==

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

    public function ocRequerimientos()
    {
        return $this->hasMany(OcRequerimiento::class, 'id_oc');
    }

    // == ACCESSORS ==

    // Devuelve la URL pública del archivo OC
    public function getArchivoOcUrlAttribute()
    {
        return $this->archivo_oc_path
            ? asset('storage/' . $this->archivo_oc_path)
            : null;
    }
}
