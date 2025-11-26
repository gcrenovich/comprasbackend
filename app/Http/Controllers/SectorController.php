<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SectorService;

class SectorController extends Controller
{
    protected $service;

    public function __construct(SectorService $service)
    {
        $this->service = $service;
    }

    public function listar()
    {
        return response()->json($this->service->listar());
    }

    public function ver($id)
    {
        return response()->json($this->service->ver((int)$id));
    }

    public function crear(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string'
        ]);

        return response()->json($this->service->crear($data), 201);
    }

    public function actualizar(Request $request, $id)
    {
        $data = $request->validate([
            'nombre' => 'string|nullable',
            'descripcion' => 'string|nullable'
        ]);

        return response()->json($this->service->actualizar((int)$id, $data));
    }
}
