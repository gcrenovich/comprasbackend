<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArchivoService;

class DocumentoController extends Controller
{
    protected $archivoService;

    public function __construct(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }

    public function subir(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'path'    => 'required|string'
        ]);

        return $this->archivoService->subirArchivo($request->file('archivo'), $request->path);
    }
}
