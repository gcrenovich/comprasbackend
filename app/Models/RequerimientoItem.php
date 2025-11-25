<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequerimientoItem extends Model
{
    protected $table = 'requerimiento_items';
    protected $primaryKey = 'id_req_item';
    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento',
        'id_item',
        'cantidad',
        'unidad_medida',
        'detalle'
    ];

    protected $casts = [
        'cantidad' => 'decimal:4',
    ];

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }

    public function item()
    {
        return $this->belongsTo(CatalogoItem::class, 'id_item');
    }

    public function presupuestoItems()
    {
        return $this->hasMany(PresupuestoItem::class, 'id_req_item');
    }
}
