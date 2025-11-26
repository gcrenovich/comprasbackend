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

    public function vincular(Request $request)
    {
        $request->validate([
            'id_oc'           => 'required|integer',
            'id_requerimiento'=> 'required|integer',
            'id_usuario'      => 'required|integer'
        ]);

        return $this->service->vincularOC(
            $request->id_oc,
            $request->id_requerimiento,
            $request->id_usuario
        );
    }
}
