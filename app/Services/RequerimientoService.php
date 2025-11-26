<?php

namespace App\Services;

use App\Models\Requerimiento;
use App\Models\HistorialEstado;
use Illuminate\Support\Facades\DB;

class RequerimientoService
{
    /**
     * Crear un nuevo requerimiento
     */
    public function crear($request)
    {
        $req = Requerimiento::create([
            'numero_pic'        => $request->numero_pic,
            'id_sector'         => $request->id_sector,
            'id_centro_costo'   => $request->id_centro_costo,
            'id_usuario_crea'   => $request->id_usuario_crea,
            'id_usuario_modifica' => $request->id_usuario_crea,
            'fecha_creacion'    => now(),
            'fecha_modificacion'=> now(),
            'estado'            => 'PENDIENTE',
            'prioridad'         => $request->prioridad ?? 'NORMAL',
            'motivo'            => $request->motivo,
            'observaciones'     => $request->observaciones
        ]);

        return [
            'message' => 'Requerimiento creado correctamente',
            'data'    => $req
        ];
    }

    /**
     * Actualizar un requerimiento existente
     */
    public function actualizar($id, $request)
    {
        $req = Requerimiento::find($id);

        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        $req->update([
            'id_sector'         => $request->id_sector ?? $req->id_sector,
            'id_centro_costo'   => $request->id_centro_costo ?? $req->id_centro_costo,
            'id_usuario_modifica' => $request->id_usuario_modifica,
            'fecha_modificacion'=> now(),
            'prioridad'         => $request->prioridad ?? $req->prioridad,
            'motivo'            => $request->motivo ?? $req->motivo,
            'observaciones'     => $request->observaciones ?? $req->observaciones
        ]);

        return [
            'message' => 'Requerimiento actualizado',
            'data'    => $req
        ];
    }

    /**
     * Cambiar estado con historial
     */
    public function cambiarEstado($idReq, $nuevoEstado, $idUsuario, $comentario = null)
    {
        $req = Requerimiento::find($idReq);

        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        $estadoAnterior = $req->estado;

        DB::transaction(function () use ($req, $nuevoEstado, $estadoAnterior, $idUsuario, $comentario) {
            // Cambiar estado
            $req->estado = $nuevoEstado;
            $req->fecha_modificacion = now();
            $req->id_usuario_modifica = $idUsuario;
            $req->save();

            // Guardar historial
            HistorialEstado::create([
                'id_requerimiento' => $req->id_requerimiento,
                'estado_anterior'  => $estadoAnterior,
                'estado_nuevo'     => $nuevoEstado,
                'id_usuario'       => $idUsuario,
                'fecha'            => now(),
                'comentario'       => $comentario
            ]);
        });

        return [
            'message' => 'Estado actualizado correctamente',
            'nuevo_estado' => $nuevoEstado
        ];
    }

    /**
     * Ver un requerimiento con relaciones
     */
    public function ver($id)
    {
        $req = Requerimiento::with([
            'sector',
            'centroCosto',
            'creador',
            'modificador',
            'items',
            'presupuestos',
            'ordenesCompra',
        ])->find($id);

        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        return $req;
    }

    /**
     * Listar requerimientos por sector
     */
    public function listarPorSector($idSector)
    {
        return Requerimiento::with(['centroCosto', 'creador'])
            ->where('id_sector', $idSector)
            ->orderBy('fecha_creacion', 'desc')
            ->get();
    }
}
