<?php

namespace App\Services;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Interfaces\WarehouseServiceInterface;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * Получить список складов.
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllWarehouses(Request $request)
    {
        return Warehouse::paginate($request->pageSize);
    }
}