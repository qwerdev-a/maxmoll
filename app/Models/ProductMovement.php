<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductMovement
 *
 * @package App\Models
 */
class ProductMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'movement_type',
    ];

    /**
     * Получить товар, связанный с движением.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Получить склад, связанный с движением.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
