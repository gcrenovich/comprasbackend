<?php

namespace App\Services;

use App\Models\Presupuesto;
use App\Models\PresupuestoItem;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresupuestoService
{
    /**
     * Crear cotización o recotización
     */
    public function crear($request)
    {
        $req = Requerimiento::find($request->id_requerimiento);

        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        // GENERAR VERSION AUTOMÁTICA
        $ultimaVersion = Presupuesto::where('id_requerimiento', $req->id_requerimiento)
            ->where('id_proveedor', $request->id_proveedor)
            ->max('version');

        $version = $ultimaVersion ? $ultimaVersion + 1 : 1;

        // GUARDAR ARCHIVO (si viene)
        $archivoPath = null;

        if ($request->hasFile('archivo')) {

            $folder = "uploads/presupuestos/" . $req->numero_pic;

            $filename = date('Ymd') . "_presu_v{$version}_" . uniqid() . "." . $request->file('archivo')->getClientOriginalExtension();

            Storage::disk('local')->putFileAs(
                $folder,
                $request->file('archivo'),
                $filename
            );

            $archivoPath = $folder . "/" . $filename;
        }

        // CREAR PRESUPUESTO
        $presupuesto = Presupuesto::create([
            'id_requerimiento' => $req->id_requerimiento,
            'id_proveedor'     => $request->id_proveedor,
            'version'          => $version,
            'moneda'           => $request->moneda ?? 'ARS',
            'observacion'      => $request->observacion,
            'archivo_path'     => $archivoPath,
            'usuario_carga'    => $request->id_usuario ?? null,
            'es_valido'        => true,
        ]);

        return response()->json([
            'message'     => 'Cotización registrada correctamente',
            'presupuesto' => $presupuesto
        ], 201);
    }

    /**
     * Listar presupuestos por requerimiento
     */
    public function listarPorRequerimiento($idReq)
    {
        return Presupuesto::with(['proveedor'])
            ->where('id_requerimiento', $idReq)
            ->orderBy('version', 'desc')
            ->get();
    }
}
