<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaRequerimiento extends Model
{
    protected $table = 'auditoria_requerimientos';
    protected $primaryKey = 'id_auditoria';
    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento',
        'accion',
        'id_usuario',
        'fecha',
        'detalle'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
