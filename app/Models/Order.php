<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package App\Models
 */
class Order extends Model
{
    protected $fillable = [
        'customer',
        'status',
        'warehouse_id'
    ];

    /**
     * Связь с таблицей order_items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Связь с таблицей warehouses.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
