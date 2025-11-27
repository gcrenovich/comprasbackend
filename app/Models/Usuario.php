<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;


    protected $fillable = [
  'nombre_completo',
  'email',
  'id_sector',
  'rol',
  'puede_aprobar_nivel1',
  'puede_aprobar_nivel2',
  'activo',
  'fecha_creacion',
  'password'
];


    protected $casts = [
        'puede_aprobar_nivel1' => 'boolean',
        'puede_aprobar_nivel2' => 'boolean',
        'activo' => 'boolean',
        'fecha_creacion' => 'datetime',
        'rol' => 'string'
    ];

    // ===============================
    // RELACIONES
    // ===============================

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector', 'id_sector');
    }

    public function requerimientosCreados()
    {
        return $this->hasMany(Requerimiento::class, 'id_usuario_crea', 'id_usuario');
    }

    public function requerimientosModificados()
    {
        return $this->hasMany(Requerimiento::class, 'id_usuario_modifica', 'id_usuario');
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class, 'id_usuario', 'id_usuario');
    }

    public function auditorias()
    {
        return $this->hasMany(AuditoriaRequerimiento::class, 'id_usuario', 'id_usuario');
    }

    // ===============================
    // MÉTODOS DE AYUDA
    // ===============================

    public function isAdmin()
    {
        return $this->rol === 'ADMIN';
    }
}
