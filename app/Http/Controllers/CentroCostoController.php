<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CentroCostoService;

class CentroCostoController extends Controller
{
    protected $service;

    public function __construct(CentroCostoService $service)
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
}
