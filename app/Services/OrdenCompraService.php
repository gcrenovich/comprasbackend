<?php

namespace App\Services;

use App\Models\OrdenCompra;
use App\Models\OcRequerimiento;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;

class OrdenCompraService
{
    /**
     * Crear una Orden de Compra (OC)
     */
    public function crearOC($numero_oc, $id_proveedor, $observacion = null, $archivo_oc_path = null)
    {
        $oc = OrdenCompra::create([
            'numero_oc'      => $numero_oc,
            'id_proveedor'   => $id_proveedor,
            'observacion'    => $observacion,
            'archivo_oc_path'=> $archivo_oc_path,
        ]);

        return [
            'message' => 'OC creada correctamente',
            'oc'      => $oc
        ];
    }


    /**
     * Obtener una OC
     */
    public function verOC($id_oc)
    {
        $oc = OrdenCompra::with(['proveedor', 'requerimientos'])->find($id_oc);

        if (!$oc) {
            return response()->json(['error' => 'OC no encontrada'], 404);
        }

        return $oc;
    }


    /**
     * VINCULAR OC ↔ REQUERIMIENTO usando SP
     */
    public function vincularOC($id_oc, $id_requerimiento, $id_usuario)
    {
        // Verificar existencia antes de llamar al SP
        $oc = OrdenCompra::find($id_oc);
        if (!$oc) {
            return response()->json(['error' => 'OC no encontrada'], 404);
        }

        $req = Requerimiento::find($id_requerimiento);
        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        // Llamada al procedimiento almacenado creado en tu SQL:
        // sp_registrar_oc_requerimiento(id_oc, id_requerimiento, id_usuario)

        DB::select("SELECT sp_registrar_oc_requerimiento(?, ?, ?)", [
            $id_oc,
            $id_requerimiento,
            $id_usuario
        ]);

        return [
            'message' => 'OC vinculada correctamente al requerimiento',
            'id_oc'   => $id_oc,
            'id_requerimiento' => $id_requerimiento
        ];
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
