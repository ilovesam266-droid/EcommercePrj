<?php

namespace App\Livewire\Admin\ProductVariant;

use App\Http\Requests\ProductVariantRequest;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Livewire\Component;

class CreateProductVariant extends Component
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepository;
    public $productId = null;
    public $variant_size = '';
    public $sku = '';
    public $price = 0;
    public $total_sold = 0;
    public $stock = 0;

    public function boot(ProductVariantSizeRepositoryInterface $repository)
    {
        $this->productVariantRepository = $repository;
    }

    public function rules()
    {
        return (new ProductVariantRequest()->rules());
    }

    public function messages()
    {
        return (new ProductVariantRequest()->messages());
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

        $this->productVariantRepository->create($productVariantData);
        $this->reset(['variant_size', 'sku', 'price', 'total_sold', 'stock']);
        session()->flash('message', 'Product variant created successfully!');
    }

    public function render()
    {
        return view('admin.pages.product-variant.create');
    }
}
