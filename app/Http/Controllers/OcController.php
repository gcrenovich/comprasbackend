<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrdenCompraService;

class OcController extends Controller
{
    protected $service;

    public function __construct(OrdenCompraService $service)
    {
        $this->service = $service;
    }

    /**
     * Crear OC
     */
    public function crear(Request $request)
    {
        $request->validate([
            'numero_oc'    => 'required|string',
            'id_proveedor' => 'required|integer',
            'archivo'      => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        return $this->service->crear($request);
    }

    /**
     * Ver OC
     */
    public function ver($id)
    {
        return $this->service->ver($id);
    }

    /**
     * Vincular OC con un Requerimiento
     */
    public function vincular(Request $request)
    {
        $request->validate([
            'id_oc'            => 'required|integer',
            'id_requerimiento' => 'required|integer',
            'id_usuario'       => 'required|integer'
        ]);

        return $this->service->vincularOC(
            $request->id_oc,
            $request->id_requerimiento,
            $request->id_usuario
        );
    }
}
