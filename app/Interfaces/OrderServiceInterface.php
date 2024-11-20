<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Интерфейс для работы с заказами.
 */
interface OrderServiceInterface
{
    /**
     * Получить список заказов с фильтрацией и пагинацией.
     *
     * @param Request $request
     * @return mixed
     */
    public function getOrders(Request $request);

    /**
     * Создать новый заказ.
     *
     * @param array $data
     * @return array
     */
    public function createOrder(array $data);

    /**
     * Обновить заказ.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateOrder(int $id, array $data);
    
    /**
     * Завершить заказ.
     *
     * @param int $id
     * @return array
     */
    public function completeOrder(int $id);

    /**
     * Отменить заказ.
     *
     * @param int $id
     * @return array
     */
    public function cancelOrder(int $id);

    /**
     * Возобновить заказ.
     *
     * @param int $id
     * @return array
     */
    public function resumeOrder(int $id);
}
