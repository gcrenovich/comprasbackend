<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Requerimiento;

class ReportesService
{
    public function porSector(int $idSector)
    {
        return Requerimiento::where('id_sector', $idSector)
            ->orderBy('fecha_creacion', 'desc')
            ->get();
    }

    public function historial(int $idReq)
    {
        return Requerimiento::with('historialEstados.usuario')
            ->findOrFail($idReq)
            ->historialEstados;
    }

    public function comparativaPresupuestos(int $idReq)
    {
        return DB::table('vw_comparativa_requerimiento')
            ->where('id_requerimiento', $idReq)
            ->get();
    }
}
