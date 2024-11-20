<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    /**
     * Связь с таблицей stocks.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Связь с таблицей order_items.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
