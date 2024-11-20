<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 * Интерфейс для работы со складами.
 */
interface ProductServiceInterface
{
    /**
     * Получить список товаров.
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllProductsWithStock(Request $request);

    /**
     * Получить список движений.
     *
     * @param Request $request
     * @return mixed
     */
    public function getProductMovements(Request $request);
}