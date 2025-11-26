<?php

namespace App\Services;

use App\Models\Presupuesto;
use App\Models\PresupuestoItem;
use Illuminate\Support\Facades\DB;

class PresupuestoService
{
    public function registrar(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $pres = Presupuesto::create($data);

            foreach ($items as $item) {
                $item['id_presupuesto'] = $pres->id_presupuesto;
                PresupuestoItem::create($item);
            }

            return $pres;
        });
    }

    public function crearNuevaVersion(int $idReq, int $idProv, array $data, array $items)
    {
        $ultimaVersion = Presupuesto::where('id_requerimiento', $idReq)
            ->where('id_proveedor', $idProv)
            ->max('version');

        $data['version'] = $ultimaVersion + 1;

        return $this->registrar($data, $items);
    }
}
