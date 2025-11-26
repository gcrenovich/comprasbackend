<?php

namespace App\Services;

use App\Models\Sector;

class SectorService
{
    public function listar()
    {
        return Sector::orderBy('nombre')->get();
    }
}
