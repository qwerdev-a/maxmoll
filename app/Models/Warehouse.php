<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Warehouse
 *
 * @package App\Models
 */
class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Связь с таблицей stocks.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Связь с таблицей orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
