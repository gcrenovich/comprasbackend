<?php

namespace App\Services;

use App\Models\CentroCosto;

class CentroCostoService
{
    /**
     * Lista todos los centros de costo (importados desde DECANO, lectura)
     */
    public function listar()
    {
        return CentroCosto::orderBy('codigo')->get();
    }

    public function ver($id)
    {
        return CentroCosto::findOrFail($id);
    }
}
