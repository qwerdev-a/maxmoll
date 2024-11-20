<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\ProductServiceInterface;

class ProductController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    protected $productService;

    /**
     * ProductController конструктор.
     *
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Получить список товаров с остатком и пагинацией.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $products = $this->productService->getAllProductsWithStock($request);
        return response()->json($products);
    }

    /**
     * Получить историю движений товаров с фильтрами и пагинацией.
     *
     * @param Request $request
     * @return Response
     */
    public function getMovements(Request $request)
    {
        $movements = $this->productService->getProductMovements($request);
        return response()->json($movements);
    }
}
