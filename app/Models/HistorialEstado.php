<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento',
        'estado_anterior',
        'estado_nuevo',
        'id_usuario',
        'fecha',
        'comentario'
    ];

   

    protected $casts = [
    'fecha' => 'datetime',
    'estado_anterior' => 'string',
    'estado_nuevo' => 'string',
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
