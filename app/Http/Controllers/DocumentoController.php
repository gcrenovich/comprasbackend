<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ArchivoService
{
    /**
     * Sube un archivo a /storage/app/public/{rutaPersonalizada}
     */
    public function subirArchivo($archivo, $ruta)
    {
        // Normaliza la ruta sin barras de más
        $ruta = trim($ruta, '/');

        // Guarda el archivo
        $path = $archivo->store("public/$ruta");

        // Convierte storage/public/... a URL accesible
        $publicPath = str_replace("public/", "storage/", $path);

        return [
            'message' => 'Archivo subido correctamente',
            'path'    => $publicPath
        ];
    }
}
