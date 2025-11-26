<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProveedorService;

class ProveedorController extends Controller
{
    protected $service;

    public function __construct(ProveedorService $service)
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

    public function crear(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'contacto' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'condicion_pago' => 'nullable|string',
            'activo' => 'boolean|nullable'
        ]);

        return response()->json($this->service->crear($data), 201);
    }

    public function actualizar(Request $request, $id)
    {
        $data = $request->validate([
            'nombre' => 'string|nullable',
            'contacto' => 'string|nullable',
            'telefono' => 'string|nullable',
            'email' => 'email|nullable',
            'condicion_pago' => 'string|nullable',
            'activo' => 'boolean|nullable'
        ]);

        return response()->json($this->service->actualizar((int)$id, $data));
    }

    public function ver($id)
    {
        return response()->json($this->service->ver((int)$id));
    }
}
