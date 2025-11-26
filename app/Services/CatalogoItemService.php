<?php

namespace App\Services;

use App\Models\CatalogoItem;

class CatalogoItemService
{
    public function listarActivos()
    {
        return CatalogoItem::where('activo', true)->orderBy('descripcion')->get();
    }

    public function listarTodos()
    {
        return CatalogoItem::orderBy('descripcion')->get();
    }

    public function ver(int $id)
    {
        return CatalogoItem::findOrFail($id);
    }

    public function crear(array $data)
    {
        $data['activo'] = $data['activo'] ?? true;
        return CatalogoItem::create($data);
    }

    public function actualizar(int $id, array $data)
    {
        $c = CatalogoItem::find($id);
        if (!$c) {
            return response()->json(['error' => 'Item no encontrado'], 404);
        }
        $c->update($data);
        return $c;
    }

    public function eliminar(int $id)
    {
        $c = CatalogoItem::find($id);
        if (!$c) {
            return response()->json(['error' => 'Item no encontrado'], 404);
        }
        $c->delete();
        return response()->json(['message' => 'Item eliminado']);
    }
}
