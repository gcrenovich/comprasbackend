<?php

namespace App\Services;

use App\Models\RequerimientoItem;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;

class RequerimientoItemService
{
    /**
     * Agregar items a un requerimiento (array de items)
     * $items: [ ['id_item'=>1,'cantidad'=>2,'unidad_medida'=>'u','detalle'=>'...'], ... ]
     */
    public function agregarItems(int $idRequerimiento, array $items)
    {
        $req = Requerimiento::find($idRequerimiento);
        if (!$req) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        return DB::transaction(function () use ($idRequerimiento, $items) {
            $created = [];
            foreach ($items as $it) {
                $it['id_requerimiento'] = $idRequerimiento;
                $created[] = RequerimientoItem::create($it);
            }
            return $created;
        });
    }

    /**
     * Actualizar un item individual
     */
    public function actualizarItem(int $idItem, array $data)
    {
        $item = RequerimientoItem::find($idItem);
        if (!$item) {
            return response()->json(['error' => 'Item no encontrado'], 404);
        }
        $item->update($data);
        return $item;
    }

    /**
     * Eliminar un item
     */
    public function eliminarItem(int $idItem)
    {
        $item = RequerimientoItem::find($idItem);
        if (!$item) {
            return response()->json(['error' => 'Item no encontrado'], 404);
        }
        $item->delete();
        return response()->json(['message' => 'Item eliminado']);
    }

    /**
     * Listar items por requerimiento
     */
    public function listarPorRequerimiento(int $idRequerimiento)
    {
        return RequerimientoItem::with('catalogoItem')
            ->where('id_requerimiento', $idRequerimiento)
            ->get();
    }
}
