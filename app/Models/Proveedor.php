<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email',
        'condicion_pago',
        'activo',
        'fecha_alta'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_alta' => 'datetime',
    ];

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'id_proveedor');
    }

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'id_proveedor');
    }
}
