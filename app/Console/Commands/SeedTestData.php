<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\ProductMovement;
use Illuminate\Console\Command;

class SeedTestData extends Command
{
    protected $signature = 'seed:test-data';
    protected $description = 'Заполнение тестовыми данными для товаров, складов и остатков';

    public function handle()
    {
        // Наполняем товары
        $products = Product::factory()->count(10)->create();  // Создадим 10 товаров

        // Наполняем склады
        $warehouses = Warehouse::factory()->count(3)->create();  // Создадим 3 склада

        // Наполняем остатки
        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                Stock::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'stock' => rand(50, 100),  // Случайное количество товара на складе
                ]);
            }
        }

        $this->info('Тестовые данные успешно добавлены!');
    }
}
