<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequerimientoItemService;

class RequerimientoItemController extends Controller
{
    protected $service;

    public function __construct(RequerimientoItemService $service)
    {
        $this->service = $service;
    }

    // POST /requerimientos/{id}/items
    public function agregar(Request $request, $id)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_item' => 'required|integer',
            'items.*.cantidad' => 'required|numeric',
            'items.*.unidad_medida' => 'nullable|string',
            'items.*.detalle' => 'nullable|string',
        ]);

        return response()->json(
            $this->service->agregarItems((int)$id, $data['items']),
            201
        );
    }

    // PUT /items/{id}
    public function actualizar(Request $request, $id)
    {
        $data = $request->validate([
            'id_item' => 'integer|nullable',
            'cantidad' => 'numeric|nullable',
            'unidad_medida' => 'string|nullable',
            'detalle' => 'string|nullable',
        ]);

        return response()->json($this->service->actualizarItem((int)$id, $data));
    }

    // DELETE /items/{id}
    public function eliminar($id)
    {
        return $this->service->eliminarItem((int)$id);
    }

    // GET /requerimientos/{id}/items
    public function listarPorRequerimiento($id)
    {
        return response()->json($this->service->listarPorRequerimiento((int)$id));
    }
}
