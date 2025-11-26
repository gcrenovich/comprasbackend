<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ArchivoService
{
    public function guardarArchivo($file, string $ruta)
    {
        return Storage::disk('local')->put($ruta, $file);
    }

    public function obtenerRutaPresupuesto(int $numeroPic, int $version, int $idPresupuesto)
    {
        $fecha = date('Ymd');

        return "uploads/presupuestos/{$numeroPic}/{$fecha}_presu_v{$version}_{$idPresupuesto}.pdf";
    }

    public function obtenerRutaFirma(int $numeroPic, int $idReq)
    {
        $fecha = date('Ymd');

        return "uploads/pic/{$numeroPic}/{$fecha}_firma_{$idReq}.pdf";
    }

    public function obtenerRutaOC(int $numeroOc)
    {
        $fecha = date('Ymd');

        return "uploads/oc/{$numeroOc}/{$fecha}_oc_{$numeroOc}.pdf";
    }
}
