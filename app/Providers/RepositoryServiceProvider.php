<?php

namespace App\Providers;

use App\Repository\Constracts\CategoryRepositoryInterface;
use App\Repository\Constracts\ImageRepositoryInterface;
use App\Repository\Constracts\MailRepositoryInterface;
use App\Repository\Constracts\OrderItemRepositoryInterface;
use App\Repository\Constracts\OrderRepositoryInterface;
use App\Repository\Constracts\ProductRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use App\Repository\Constracts\UserRepositoryInterface;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ImageRepository;
use App\Repository\Eloquent\MailRepository;
use App\Repository\Eloquent\OrderItemRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\ProductVariantSizeRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        ImageRepositoryInterface::class => ImageRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        ProductVariantSizeRepositoryInterface::class => ProductVariantSizeRepository::class,
        OrderRepositoryInterface::class => OrderRepository::class,
        OrderItemRepositoryInterface::class => OrderItemRepository::class,
        MailRepositoryInterface::class => MailRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
