<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    protected $table = 'requerimientos';
    protected $primaryKey = 'id_requerimiento';
    public $timestamps = false;

    protected $fillable = [
        'numero_pic',
        'id_sector',
        'id_centro_costo',
        'id_usuario_crea',
        'id_usuario_modifica',
        'fecha_creacion',
        'fecha_modificacion',
        'estado',
        'prioridad',
        'motivo',
        'archivo_firma_path',
        'observaciones'
    ];

    protected $casts = [
        'fecha_creacion'      => 'datetime',
        'fecha_modificacion'  => 'datetime',
        'estado'              => 'string',
    ];

    // ==========================
    // RELACIONES
    // ==========================

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector', 'id_sector');
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'id_centro_costo');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_crea', 'id_usuario');
    }

    public function modificador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_modifica', 'id_usuario');
    }

    public function items()
    {
        return $this->hasMany(RequerimientoItem::class, 'id_requerimiento', 'id_requerimiento');
    }

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'id_requerimiento');
    }

    public function ordenesCompra()
    {
        return $this->belongsToMany(
            OrdenCompra::class,
            'oc_requerimiento',
            'id_requerimiento',
            'id_oc'
        );
    }

    public function historial()
    {
        return $this->hasMany(HistorialEstado::class, 'id_requerimiento');
    }

    public function auditoria()
    {
        return $this->hasMany(AuditoriaRequerimiento::class, 'id_requerimiento');
    }

    // ==========================
    // ACCESSORS
    // ==========================

    public function getArchivoFirmaUrlAttribute()
    {
        return $this->archivo_firma_path
            ? asset('storage/' . $this->archivo_firma_path)
            : null;
    }
}
