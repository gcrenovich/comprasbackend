<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CatalogoItemService;

class CatalogoItemController extends Controller
{
    protected $service;

    public function __construct(CatalogoItemService $service)
    {
        $this->service = $service;
    }

    public function listarActivos()
    {
        return response()->json($this->service->listarActivos());
    }

    public function listar()
    {
        return response()->json($this->service->listarTodos());
    }

    public function ver($id)
    {
        return response()->json($this->service->ver((int)$id));
    }

    public function crear(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
            'unidad_medida' => 'nullable|string',
            'categoria' => 'nullable|string',
            'activo' => 'boolean|nullable'
        ]);

        return response()->json($this->service->crear($data), 201);
    }

    public function actualizar(Request $request, $id)
    {
        $data = $request->validate([
            'codigo' => 'string|nullable',
            'descripcion' => 'string|nullable',
            'unidad_medida' => 'string|nullable',
            'categoria' => 'string|nullable',
            'activo' => 'boolean|nullable'
        ]);

        return response()->json($this->service->actualizar((int)$id, $data));
    }

    public function eliminar($id)
    {
        return $this->service->eliminar((int)$id);
    }
}
