<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Http\Request;
use App\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    /**
     * Получить список товаров с остатком и пагинацией.
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllProductsWithStock(Request $request) {
        $query = Product::with('stocks');

        return $query->paginate($request->pageSize);
    }

    /**
     * Получить список движений товаров с фильтрацией и пагинацией.
     *
     * @param Request $request
     * @return mixed
     */
    public function getProductMovements(Request $request) {
        $query = ProductMovement::query();

        // Фильтр по складку
        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->input('warehouse_id'));
        }

        // Фильтр по товару
        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        // Фильтр по датам
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        // Пагинация
        return $query->paginate($request->pageSize);
    }
}