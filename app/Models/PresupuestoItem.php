<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoItem extends Model
{
    protected $table = 'presupuesto_items';
    protected $primaryKey = 'id_presu_item';
    public $timestamps = false;

    protected $fillable = [
        'id_presupuesto',
        'id_req_item',
        'id_item',
        'precio_unitario',
        'plazo_entrega',
        'observaciones'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:4',
    ];

    // ==========================
    // RELACIONES
    // ==========================

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'id_presupuesto');
    }

    public function requerimientoItem()
    {
        return $this->belongsTo(RequerimientoItem::class, 'id_req_item');
    }

    public function catalogoItem()
    {
        return $this->belongsTo(CatalogoItem::class, 'id_item');
    }
}
