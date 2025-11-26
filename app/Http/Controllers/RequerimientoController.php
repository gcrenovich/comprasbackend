<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequerimientoService;

class RequerimientoController extends Controller
{
    protected $service;

    public function __construct(RequerimientoService $service)
    {
        $this->service = $service;
    }

    public function crear(Request $request)
    {
        return $this->service->crear($request);
    }

    public function actualizar($id, Request $request)
    {
        return $this->service->actualizar($id, $request);
    }

    public function cambiarEstado(Request $request)
    {
        $request->validate([
            'id_requerimiento' => 'required|integer',
            'estado'           => 'required|string',
            'id_usuario'       => 'required|integer'
        ]);

        return $this->service->cambiarEstado(
            $request->id_requerimiento,
            $request->estado,
            $request->id_usuario,
            $request->comentario
        );
    }

    public function ver($id)
    {
        return $this->service->ver($id);
    }

    public function listarPorSector($idSector)
    {
        return $this->service->listarPorSector($idSector);
    }
}
