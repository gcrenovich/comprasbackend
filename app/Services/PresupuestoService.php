<?php

namespace App\Services;

use App\Models\Presupuesto;
use App\Models\PresupuestoItem;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;

class PresupuestoService
{
    /**
     * Crear un nuevo presupuesto (cotización)
     * Soporta versiones (re-cotizaciones)
     */
    public function crear($request)
    {
        $idReq  = $request->id_requerimiento;
        $idProv = $request->id_proveedor;

        // Verificar que el requerimiento exista
        $req = Requerimiento::find($idReq);
        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        // Obtener versión actual (si existe)
        $ultima = Presupuesto::where('id_requerimiento', $idReq)
                             ->where('id_proveedor', $idProv)
                             ->orderBy('version', 'desc')
                             ->first();

        $nuevaVersion = $ultima ? $ultima->version + 1 : 1;

        // Subir archivo si viene adjunto
        $filePath = null;
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = "presupuesto_{$idReq}_v{$nuevaVersion}_" . time() . "." . $file->getClientOriginalExtension();
            $folder = "uploads/presupuestos/{$idReq}";
            $filePath = $file->storeAs($folder, $fileName, 'public');
        }

        // Crear el presupuesto
        $presupuesto = Presupuesto::create([
            'id_requerimiento' => $idReq,
            'id_proveedor'     => $idProv,
            'version'          => $nuevaVersion,
            'moneda'           => $request->moneda ?? 'ARS',
            'observacion'      => $request->observacion,
            'archivo_path'     => $filePath,
            'usuario_carga'    => $request->id_usuario ?? null,
            'es_valido'        => true
        ]);

        return [
            'message'     => 'Presupuesto cargado correctamente',
            'presupuesto' => $presupuesto
        ];
    }


    /**
     * Listar presupuestos por requerimiento
     */
    public function listarPorRequerimiento($idReq)
    {
        $presus = Presupuesto::with(['proveedor'])
                    ->where('id_requerimiento', $idReq)
                    ->orderBy('version')
                    ->get();

        if ($presus->isEmpty()) {
            return response()->json(['message' => 'No hay presupuestos para este requerimiento'], 200);
        }

        return $presus;
    }
}
