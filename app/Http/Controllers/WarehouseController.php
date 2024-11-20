<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\WarehouseServiceInterface;

/**
 * WarehouseController управляет складами.
 */
class WarehouseController extends Controller
{
    /**
     * @var WarehouseServiceInterface
     */
    protected $warehouseService;

    /**
     * ProductController конструктор.
     *
     * @param WarehouseController $warehouseService
     */
    public function __construct(WarehouseServiceInterface $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * Получить список складов с пагинацией.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $warehouses = $this->warehouseService->getAllWarehouses($request);
        return response()->json($warehouses);
    }
}
