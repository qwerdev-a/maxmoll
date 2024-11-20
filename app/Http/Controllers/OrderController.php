<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\OrderServiceInterface;

/**
 * OrderController управляет заказами.
 */
class OrderController extends Controller
{
    /**
     * @var OrderServiceInterface
     */
    private $orderService;

    /**
     * OrderController конструктор.
     *
     * @param OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Получить список заказов с фильтрацией и пагинацией.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $orders = $this->orderService->getOrders($request);
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Создать новый заказ.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string',
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.count' => 'required|integer|min:1',
        ]);

        try {
            $order = $this->orderService->createOrder($data);

            if($order['status'] == 'error') {
                return response()->json($order, 400);
            }

            return response()->json($order, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Обновить заказ.
     *
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'customer' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.count' => 'required_with:items|integer|min:1',
        ]);

        try {
            $order = $this->orderService->updateOrder($id, $data);

            if($order['status'] == 'error') {
                return response()->json($order, 400);
            }

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Завершить заказ.
     *
     * @param int $id
     * @return Response
     */
    public function complete($id)
    {
        try {
            $order = $this->orderService->completeOrder($id);

            if($order['status'] == 'error') {
                return response()->json($order, 400);
            }

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Отменить заказ.
     *
     * @param int $id
     * @return Response
     */
    public function cancel($id)
    {
        try {
            $order = $this->orderService->cancelOrder($id);

            if($order['status'] == 'error') {
                return response()->json($order, 400);
            }

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Возобновить заказ.
     *
     * @param int $id
     * @return Response
     */
    public function resume($id)
    {
        try {
            $order = $this->orderService->resumeOrder($id);

            if($order['status'] == 'error') {
                return response()->json($order, 400);
            }

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}