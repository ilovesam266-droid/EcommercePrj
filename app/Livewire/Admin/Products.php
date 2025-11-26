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
    public string $search = '';
    public array $filter = [
        'status' => '',
    ];
    public int $perPage;
    public string $sort;

    public function boot(ProductRepositoryInterface $repository)
    {
        $this->productRepository = $repository;
    }

    public function mount(){
        $this->sort = config('app.sort');
        $this->perPage = config('app.per_page');
    }

    public function confirmDelete($productId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm product deletion',
            'Are you sure you want to delete this product #PRODUCT-<<'.$productId.'>>?',
            'delete-product',
            ['product_id' => $productId],
        );
    }

    #[On('delete-product')]
    public function deleteProduct($data)
    {
        $productId = $data['product_id'];
        $this->productRepository->delete($productId);
        $this->dispatch('showToast', 'success', 'Success', 'Product Deleted');
    }

    #[On('searchPerformed')]
    public function updatedSearchTemp($searchTemp)
    {
        $this->search = $searchTemp;
    }

    #[On('filterPerformed')]
    public function updatedSelectedFilter($selectedFilter)
    {
        $this->filter = array_merge($this->filter, $selectedFilter);
    }

    //after search
    #[On('resetPage')]
    public function Search()
    {
        $this->resetPage();
    }

    #[Computed]
    public function products()
    {
        return $this->productRepository->getAllProducts($this->perPage, $this->sort, $this->search, $this->filter);
    }

    #[Layout('layouts.page-layout')]
    #[Title('Products')]
    public function render()
    {
        $productFiltersConfig = [
            ['key' => 'status', 'placeholder' => 'Filter by Status', 'options' => [
                ['label' => 'Active', 'value' => 'active'],
                ['label' => 'In Active', 'value' => 'inactive'],
            ]],
        ];
        $totalStock = $this->productRepository->getTotalStock();
        $outOfStockCount = $this->productRepository->outOfStockCount();
        $lowStockCount = $this->productRepository->lowStockCount();
        return view('admin.pages.products', compact('productFiltersConfig', 'totalStock', 'outOfStockCount', 'lowStockCount'));
    }
}
