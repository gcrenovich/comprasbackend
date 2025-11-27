<?php

namespace App\Services;

use App\Models\OrdenCompra;
use App\Models\OcRequerimiento;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrdenCompraService
{
    /**
     * Crear una Orden de Compra (OC)
     */
    public function crear($request)
    {
        // Validar si el proveedor existe se hace en el controlador

        $archivoPath = null;

        if ($request->hasFile('archivo')) {
            $folder = "uploads/oc/" . $request->numero_oc;

            $filename = date('Ymd') . "_oc_" . $request->numero_oc . "." .
                        $request->file('archivo')->getClientOriginalExtension();

            Storage::disk('local')->putFileAs(
                $folder,
                $request->file('archivo'),
                $filename
            );

            $archivoPath = $folder . "/" . $filename;
        }

        // Crear OC
        $oc = OrdenCompra::create([
            'numero_oc'      => $request->numero_oc,
            'id_proveedor'   => $request->id_proveedor,
            'observacion'    => $request->observacion ?? null,
            'archivo_oc_path'=> $archivoPath
        ]);

        return response()->json([
            'message' => 'Orden de Compra creada correctamente',
            'oc'      => $oc
        ], 201);
    }


    /**
     * Obtener OC por ID
     */
    public function ver($id)
    {
        $oc = OrdenCompra::with(['proveedor', 'requerimientos'])->find($id);

        if (!$oc) {
            return response()->json(['error' => 'OC no encontrada'], 404);
        }

        return $oc;
    }


    /**
     * Vincular OC ↔ Requerimiento usando stored procedure
     */
    public function vincularOC($id_oc, $id_requerimiento, $id_usuario)
    {
        // Validaciones iniciales
        $oc = OrdenCompra::find($id_oc);
        if (!$oc) {
            return response()->json(['error' => 'OC no encontrada'], 404);
        }

        $req = Requerimiento::find($id_requerimiento);
        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        // Ejecutar SP
        DB::select("SELECT sp_registrar_oc_requerimiento(?, ?, ?)", [
            $id_oc,
            $id_requerimiento,
            $id_usuario
        ]);

        return response()->json([
            'message' => 'OC vinculada correctamente',
            'oc' => $id_oc,
            'requerimiento' => $id_requerimiento
        ]);
    }


    /**
     * Listar OCs por proveedor
     */
    public function listarPorProveedor($id_proveedor)
    {
        return OrdenCompra::where('id_proveedor', $id_proveedor)
                ->orderBy('fecha', 'desc')
                ->get();
    }
}
