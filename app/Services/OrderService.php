<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\ProductMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\OrderServiceInterface;

/**
 * Сервис для работы с заказами.
 */
class OrderService implements OrderServiceInterface
{
    /**
     * Получить список заказов с фильтрацией и пагинацией.
     *
     * @param Request $request
     * @return mixed
     */
    public function getOrders(Request $request)
    {
        $query = Order::query();

        // Применяем фильтры
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('customer')) {
            $query->where('customer', 'like', '%' . $request->input('customer') . '%');
        }

        // Пагинация
        return $query->paginate($request->pageSize);
    }

    /**
     * Создать новый заказ.
     *
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer' => $data['customer'],
                'warehouse_id' => $data['warehouse_id'],
                'status' => 'active'
            ]);

            foreach ($data['items'] as $item) {
                $stock = Stock::where('product_id', $item['product_id'])
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->first();

                if (!$stock || $stock->stock < $item['count']) {
                    DB::rollBack();
                    return [
                        'status' => 'error',
                        'error' => 'Недостаточно товаров на складе'
                    ];
                }

                // Обновляем остаток на складе
                $stock->stock -= $item['count'];
                $stock->save();

                // Логируем движение товара
                ProductMovement::create([
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'quantity' => -$item['count'],
                    'movement_type' => 'decrease',
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);
            }

            DB::commit();

            return [
                'status' => 'success',
                'order' => $order
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка при создании заказа: ' . $e->getMessage());
            throw new \Exception('Произошла ошибка при создании заказа');
        }
    }

    /**
     * Завершить заказ.
     *
     * @param int $id
     * @return Order
     */
    public function completeOrder(int $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'active') {
            return [
                'status' => 'error',
                'error' => 'Заказ уже завершен или отменен'
            ];
        }

        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();

        return [
            'status' => 'success',
            'order' => $order
        ];
    }

    /**
     * Отменить заказ.
     *
     * @param int $id
     * @return Order
     */
    public function cancelOrder(int $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'active') {
            return [
                'status' => 'error',
                'error' => 'Заказ не может быть отменен'
            ];
        }

        $order->status = 'canceled';
        $order->save();

        // Возврат товаров на склад и логирование
        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->first();

            if ($stock) {
                $stock->stock += $item->count;
                $stock->save();

                // Логируем возврат товара
                ProductMovement::create([
                    'product_id' => $item->product_id,
                    'warehouse_id' => $order->warehouse_id,
                    'quantity' => $item->count,
                    'movement_type' => 'increase',
                ]);
            }
        }

        return [
            'status' => 'success',
            'order' => $order
        ];
    }

    /**
     * Возобновить заказ.
     *
     * @param int $id
     * @param array $data
     * @return Order
     */
    public function updateOrder(int $id, array $data) {
        $order = Order::with('items')->findOrFail($id);
       
        if(isset($data['customer'])) {
            $order->update([
                'customer' => $data['customer']
            ]);
        }

        if (isset($data['items'])) {
            $order->items()->delete();
            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'count' => $item['count']
                ]);
            }
        }

        return [
            'status' => 'success',
            'order' => $order
        ];
    }

    /**
     * Возобновить заказ.
     *
     * @param int $id
     * @return Order
     */
    public function resumeOrder(int $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'canceled') {
            return [
                'status' => 'error',
                'error' => 'Заказ не отменен'
            ];
        }

        $order->status = 'active';
        $order->completed_at = null;
        $order->save();

        return [
            'status' => 'success',
            'order' => $order
        ];
    }
}
