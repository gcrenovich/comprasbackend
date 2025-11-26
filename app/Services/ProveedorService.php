<?php

namespace App\Services;

use App\Models\Proveedor;

class ProveedorService
{
    public function listarActivos()
    {
        return Proveedor::where('activo', true)->orderBy('nombre')->get();
    }

    public function listarTodos()
    {
        return Proveedor::orderBy('nombre')->get();
    }

    public function crear(array $data)
    {
        $data['activo'] = $data['activo'] ?? true;
        return Proveedor::create($data);
    }

    public function actualizar(int $id, array $data)
    {
        $prov = Proveedor::find($id);
        if (!$prov) {
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
        $prov->update($data);
        return $prov;
    }

    public function ver(int $id)
    {
        return Proveedor::findOrFail($id);
    }
}
