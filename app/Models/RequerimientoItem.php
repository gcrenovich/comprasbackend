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

    // ==========================
    // RELACIONES
    // ==========================

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }

    public function catalogoItem()
    {
        return $this->belongsTo(CatalogoItem::class, 'id_item');
    }

    public function presupuestoItems()
    {
        return $this->hasMany(PresupuestoItem::class, 'id_req_item', 'id_req_item');
    }

    // ==========================
    // ACCESSORS ÚTILES
    // ==========================

    /**
     * Devuelve la unidad de medida del ítem si no fue cargada manualmente
     */
    public function getUnidadFinalAttribute()
    {
        return $this->unidad_medida 
            ?: ($this->catalogoItem->unidad_medida ?? null);
    }
}
