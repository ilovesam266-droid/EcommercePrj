<?php

namespace App\Livewire\Admin;

use App\Models\ProductVariantSize;
use App\Repository\Constracts\ProductRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ProductVariants extends Component
{
    use WithPagination;

    protected ProductVariantSizeRepositoryInterface $productVariantRepository;
    protected ProductRepositoryInterface $productRepository;
    public int $perPage = 5;
    public array $sort = ['created_at' => 'asc'];
    public $productId = null;
    public $productVariantId = null;
    public bool $openCreateVariantModal = false;
    public bool $openEditVariantModal = false;

    public function boot(ProductVariantSizeRepositoryInterface $product_variant_size_repository, ProductRepositoryInterface $product_repository)
    {
        $this->productRepository = $product_repository;
        $this->productVariantRepository = $product_variant_size_repository;
    }

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function deleteVariant($productVariantId){
        return $this->productVariantRepository->delete($productVariantId);
    }

    public function showCreateVariantModal()
    {
        $this->openCreateVariantModal = true;
    }
    public function hideCreateVariantModal()
    {
        $this->openCreateVariantModal = false;
    }
    public function showEditVariantModal($variantId)
    {
        $this->productVariantId = $variantId;
        $this->openEditVariantModal = true;
    }
    public function hideEditVariantModal()
    {
        $this->openEditVariantModal = false;
        $this->reset(['productVariantId']);
    }


    #[Computed()]
    public function product_variants()
    {
        return $this->productVariantRepository->all(
            ['product_id' => $this->productId],
            $this->sort,
            $this->perPage,
            ['*'],
            [],
            false
        );
    }

    public function render()
    {
        return view('admin.pages.product-variants');
    }
}
