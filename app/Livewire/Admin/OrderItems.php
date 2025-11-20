<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\OrderItemRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use App\Repository\Constracts\ProductRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderItems extends Component
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepository;
    protected ProductRepositoryInterface $productRepository;
    protected OrderItemRepositoryInterface $orderItemRepository;
    public $orderId = null;
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;

    public function boot(OrderItemRepositoryInterface $order_item_repository, ProductVariantSizeRepositoryInterface $product_variant_size_repository, ProductRepositoryInterface $product_repository)
    {
        $this->orderItemRepository = $order_item_repository;
        $this->productRepository = $product_repository;
        $this->productVariantRepository = $product_variant_size_repository;
    }

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    #[Computed()]
    public function order_items()
    {
        return $this->orderItemRepository->all(
            ['order_id' => $this->orderId],
            $this->sort,
            $this->perPage,
            ['*'],
            ['productVariantSize' => function ($query) {
                $query->withTrashed();
            }, 'productVariantSize.product' => function ($query) {
                $query->withTrashed();
            }],
            false
        );
    }

    public function render()
    {
        return view('admin.pages.order-items');
    }
}
