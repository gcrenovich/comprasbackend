<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoItem extends Model
{
    protected $table = 'catalogo_items';
    protected $primaryKey = 'id_item';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'descripcion',
        'unidad_medida',
        'categoria',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function requerimientoItems()
    {
        return $this->hasMany(RequerimientoItem::class, 'id_item', 'id_item');
    }

    public function presupuestoItems()
    {
        return $this->hasMany(PresupuestoItem::class, 'id_item', 'id_item');
    }
}
