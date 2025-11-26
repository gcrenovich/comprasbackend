<?php

namespace App\Services;

use App\Models\RequerimientoItem;

class ItemService
{
    public function agregarItems(int $idReq, array $items)
    {
        foreach ($items as $item) {
            $item['id_requerimiento'] = $idReq;
            RequerimientoItem::create($item);
        }
    }
}
