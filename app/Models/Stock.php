<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 *
 * @package App\Models
 */
class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'stock'
    ];

    /**
     * Связь с продуктом.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Связь со складом.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
