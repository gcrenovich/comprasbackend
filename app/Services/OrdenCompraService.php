<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrdenCompraService
{
    public function vincular(int $idOc, int $idReq, int $idUsuario)
    {
        DB::select(
            'SELECT sp_registrar_oc_requerimiento(?, ?, ?)',
            [$idOc, $idReq, $idUsuario]
        );

        return true;
    }
}
