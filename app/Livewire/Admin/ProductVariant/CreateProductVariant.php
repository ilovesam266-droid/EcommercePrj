<?php

namespace App\Livewire\Admin\ProductVariant;

use App\Http\Requests\ProductVariantRequest;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Livewire\Component;

class CreateProductVariant extends Component
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepository;
    protected ProductVariantRequest $productVariantRequest;
    public $productId = null;
    public $variant_size = '';
    public $sku = '';
    public $price = 0;
    public $total_sold = 0;
    public $stock = 0;

    public function __construct()
    {
        $this->productVariantRequest = new ProductVariantRequest();
    }

    public function boot(ProductVariantSizeRepositoryInterface $repository)
    {
        $this->productVariantRepository = $repository;
    }

    public function rules()
    {
        return $this->productVariantRequest->rules();
    }

    public function messages()
    {
        return $this->productVariantRequest->messages();
    }

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function createProductVariant()
    {
        $this->validate();
        $productVariantData = $this->only([
            'variant_size',
            'sku',
            'price',
            'total_sold',
            'stock',
        ]);
        $productVariantData['product_id'] = $this->productId;

        $productVariant = $this->productVariantRepository->create($productVariantData);
        if ($productVariant) {
            $this->reset(['variant_size', 'sku', 'price', 'total_sold', 'stock']);
            $this->dispatch('showToast', 'success', 'Success', 'Product variant created successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Product variant created failed!');
        }
    }

    public function render()
    {
        return view('admin.pages.product-variant.create');
    }
}
