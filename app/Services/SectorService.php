<?php

namespace App\Services;

use App\Models\Sector;

class SectorService
{
    public function listar()
    {
        return Sector::orderBy('nombre')->get();
    }

    public function ver($id)
    {
        return Sector::findOrFail($id);
    }

    public function crear(array $data)
    {
        return Sector::create($data);
    }

    public function actualizar(int $id, array $data)
    {
        $s = Sector::find($id);
        if (!$s) {
            return response()->json(['error' => 'Sector no encontrado'], 404);
        }
        $s->update($data);
        return $s;
    }
}
