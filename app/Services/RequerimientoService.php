<?php

namespace App\Services;

use App\Models\Requerimiento;
use App\Models\RequerimientoItem;
use Illuminate\Support\Facades\DB;

class RequerimientoService
{
    public function crear(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $req = Requerimiento::create($data);

            foreach ($items as $item) {
                $item['id_requerimiento'] = $req->id_requerimiento;
                RequerimientoItem::create($item);
            }

            return $req;
        });
    }

    public function modificar(int $id, array $data, array $items = null)
    {
        return DB::transaction(function () use ($id, $data, $items) {

            $req = Requerimiento::findOrFail($id);
            $req->update($data);

            if ($items !== null) {
                RequerimientoItem::where('id_requerimiento', $id)->delete();

                foreach ($items as $item) {
                    $item['id_requerimiento'] = $id;
                    RequerimientoItem::create($item);
                }
            }

            return $req;
        });
    }

    public function obtener(int $id)
    {
        return Requerimiento::with([
            'sector',
            'centroCosto',
            'creador',
            'items.item',
            'presupuestos'
        ])->findOrFail($id);
    }
}
