<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestos';
    protected $primaryKey = 'id_presupuesto';
    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento',
        'id_proveedor',
        'version',
        'fecha',
        'moneda',
        'observacion',
        'archivo_path',
        'usuario_carga',
        'es_valido'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'es_valido' => 'boolean',
    ];

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function items()
    {
        return $this->hasMany(PresupuestoItem::class, 'id_presupuesto');
    }
}
