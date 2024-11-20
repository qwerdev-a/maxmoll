<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 * Интерфейс для работы со складами.
 */
interface WarehouseServiceInterface
{
    /**
     * Получить список складов.
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllWarehouses(Request $request);
}