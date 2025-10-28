<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\ProductRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected ProductRepositoryInterface $productRepository;
    public $editingProductId = null;
    public int $perPage = 5;
    public array $sort = ['created_at' => 'asc'];

    public function boot(ProductRepositoryInterface $repository)
    {
        $this->productRepository = $repository;
    }

    public function deleteProduct($productId)
    {
        return $this->productRepository->delete($productId);
    }

    public function getProduct()
    {
        return [];
    }

    #[Computed]
    public function products()
    {
        return $this->productRepository->all(
            $this->getProduct(),
            $this->sort,
            $this->perPage,
            ['*'],
            ['images' => function ($query) {
                $query->wherePivot('is_primary', true);
            }, 'categories'],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Products')]
    public function render()
    {
        return view('admin.pages.products');
    }
}
