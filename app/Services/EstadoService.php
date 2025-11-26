<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EstadoService
{
    public function cambiarEstado(int $idReq, string $nuevoEstado, int $idUsuario, string $comentario = null)
    {
        DB::select(
            'SELECT sp_cambiar_estado(?, ?, ?, ?)',
            [$idReq, $nuevoEstado, $idUsuario, $comentario]
        );

        return true;
    }
}
