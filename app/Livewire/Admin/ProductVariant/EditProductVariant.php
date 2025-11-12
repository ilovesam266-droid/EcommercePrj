<?php

namespace App\Livewire\Admin\ProductVariant;

use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use App\Http\Requests\ProductVariantRequest;
use Livewire\Component;

class EditProductVariant extends Component
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepository;
    protected ProductVariantRequest $productVariantRequest;
    public $productVariantId = null;
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

    public function mount($productVariantId)
    {
        $this->productVariantId = (int) $productVariantId;
        $this->loadProductVariant();
    }

    public function loadProductVariant()
    {
        $variant = $this->productVariantRepository->find($this->productVariantId);
        if ($variant) {
            $this->fill($variant->only([
                'variant_size',
                'sku',
                'price',
                'total_sold',
                'stock',
            ]));
        }
    }

    public function updateProductVariant()
    {
        $this->validate();
        $productVariantData = $this->only([
            'variant_size',
            'sku',
            'price',
            'total_sold',
            'stock',
        ]);
        $success = $this->productVariantRepository->update($this->productVariantId, $productVariantData);
        if ($success) {
            $this->dispatch('userUpdated');
            $this->dispatch('showToast', 'success', 'Success', 'Product variant updated successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Product variant updated failed!');
        }
    }

    public function render()
    {
        return view('admin.pages.product-variant.edit');
    }
}
