<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\OrderServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\WarehouseServiceInterface;

use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\WarehouseService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(WarehouseServiceInterface::class, WarehouseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
