<?php

namespace App\Livewire\Admin\Product;

use App\Http\Requests\ProductRequest;
use App\Repository\Constracts\ProductRepositoryInterface;
use App\Repository\Constracts\ImageRepositoryInterface;
use App\Repository\Constracts\CategoryRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditProduct extends Component
{
    protected ProductRepositoryInterface $productRepository;
    protected ImageRepositoryInterface $imageRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected ProductRequest $productRequest;
    public $productId = null;
    public $name = '';
    public $slug = '';
    public $description = null;
    public $status = 'active';
    public $selectedCategories = [];
    public $image_ids = [];

    public function __construct()
    {
        $this->productRequest = new ProductRequest();
    }

    public function boot(ProductRepositoryInterface $product_repository, ImageRepositoryInterface $image_repository, CategoryRepositoryInterface $category_repository)
    {
        $this->productRepository = $product_repository;
        $this->imageRepository = $image_repository;
        $this->categoryRepository = $category_repository;
    }

    public bool $openImageModal = false;
    public bool $openCategoryModal = false;

    public function rules()
    {
        return $this->productRequest->rules();
    }
    public function messages()
    {
        return $this->productRequest->messages();
    }

    public function mount($editingProductId)
    {
        $this->productId = (int) $editingProductId;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $product = $this->productRepository->find($this->productId);
        if ($product) {
            $this->fill($product->only([
                'name',
                'slug',
                'description',
            ]));
            $this->image_ids = $product->images->pluck('id')->toArray();
            $this->selectedCategories = $product->categories->pluck('id')->toArray();
            $this->status = $product->status->value;
        }
    }

    public function updateProduct()
    {
        $this->validate();
        $productData = $this->only([
            'name',
            'slug',
            'description',
            'status',
        ]);
        $product = $this->productRepository->update($this->productId, $productData);
        if ($product) {
            if (!empty($this->selectedCategories)) {
                $product->categories()->sync($this->selectedCategories);
            }
            if (!empty($this->image_ids)) {
                $imagePivotData = [];
                foreach ($this->image_ids as $index => $image) {
                    $imagePivotData[$image] = [
                        'is_primary' => $index == 0,
                        'order_of_images' => $index,
                    ];
                }
                $product->images()->sync($imagePivotData);
            }
            $this->dispatch('showToast', 'success', 'Success', 'Product is updated successfully!');
            return redirect(route('admin.products'));
        } else {
            $this->dispatch('showToast', 'success', 'Success', 'Product is updated failed!');
        }
    }

    #[On('imagesSelected')]
    public function uploadImage($images)
    {
        $this->image_ids = array_unique(
            array_merge($this->image_ids, $images),
            SORT_NUMERIC
        );
    }

    #[Computed()]
    public function categories()
    {
        return $this->categoryRepository->all(
            [],
            [],
            null,
            ['id', 'name'],
            [],
            false
        );
    }

    public function showImageModal()
    {
        $this->openImageModal = true;
    }
    public function hideImageModal()
    {
        $this->openImageModal = false;
    }
    public function showCategoryModal()
    {
        $this->openCategoryModal = true;
    }
    public function hideCategoryModal()
    {
        $this->openCategoryModal = false;
    }

    #[Layout('layouts.page-layout')]
    #[Title('Edit-Product')]
    public function render()
    {
        $categories = $this->categoryRepository->find($this->selectedCategories)->pluck('name')->toArray();
        $images = $this->imageRepository->find(function (&$query) {
            $query->whereIn('id', $this->image_ids)
                ->when($this->image_ids, fn($innerQuery) => $innerQuery->orderByRaw('FIELD(id, ' . implode(',', $this->image_ids) . ')'));
        }, [], true);
        return view('admin.pages.product.edit', compact('images', 'categories'));
    }
}
