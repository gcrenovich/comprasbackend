<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoService
{
    /**
     * SUBIR ARCHIVO GENÉRICO
     * Usado por DocumentoController
     */
    public function subirArchivo($file, string $rutaDestino)
    {
        // Normalizar ruta (sin barras extra)
        $rutaDestino = trim($rutaDestino, '/');

        // Crear nombre único
        $nombreArchivo = date('Ymd_His') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Ruta final dentro de storage/app/uploads/
        $rutaCompleta = "uploads/{$rutaDestino}/{$nombreArchivo}";

        // Guardar archivo
        Storage::put($rutaCompleta, file_get_contents($file));

        return [
            'message' => 'Archivo subido correctamente',
            'path'    => $rutaCompleta,
        ];
    }


    /**
     * Guarda archivo según ruta manual generada
     */
    public function guardarArchivo($file, string $ruta)
    {
        return Storage::put($ruta, file_get_contents($file));
    }


    /**
     * Obtener ruta para presupuestos
     */
    public function obtenerRutaPresupuesto(int $numeroPic, int $version, int $idPresupuesto)
    {
        $fecha = date('Ymd');

        return "uploads/presupuestos/{$numeroPic}/{$fecha}_presu_v{$version}_{$idPresupuesto}.pdf";
    }


    /**
     * Obtener ruta para firmas escaneadas
     */
    public function obtenerRutaFirma(int $numeroPic, int $idReq)
    {
        $fecha = date('Ymd');

        return "uploads/pic/{$numeroPic}/{$fecha}_firma_{$idReq}.pdf";
    }


    /**
     * Obtener ruta para OCs
     */
    public function obtenerRutaOC(int $numeroOc)
    {
        $fecha = date('Ymd');

        return "uploads/oc/{$numeroOc}/{$fecha}_oc_{$numeroOc}.pdf";
    }
}
