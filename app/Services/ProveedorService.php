<?php

namespace App\Services;

use App\Models\Proveedor;

class ProveedorService
{
    public function listarActivos()
    {
        return Proveedor::where('activo', true)->orderBy('nombre')->get();
    }
}
