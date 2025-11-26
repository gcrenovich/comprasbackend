<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PresupuestoService;

class PresupuestoController extends Controller
{
    protected $service;

    public function __construct(PresupuestoService $service)
    {
        $this->service = $service;
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_requerimiento' => 'required|integer',
            'id_proveedor'     => 'required|integer',
            'archivo'          => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        return $this->service->crear($request);
    }

    public function listarPorRequerimiento($idReq)
    {
        return $this->service->listarPorRequerimiento($idReq);
    }
}
