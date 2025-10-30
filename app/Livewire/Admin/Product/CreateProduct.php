<?php

namespace App\Livewire\Admin\Product;

use App\Http\Requests\ProductRequest;
use App\Repository\Constracts\CategoryRepositoryInterface;
use App\Repository\Constracts\ImageRepositoryInterface;
use App\Repository\Constracts\ProductRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateProduct extends Component
{
    protected ProductRepositoryInterface $productRepository;
    protected ImageRepositoryInterface $imageRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    public function boot(ProductRepositoryInterface $product_repository, ImageRepositoryInterface $image_repository, CategoryRepositoryInterface $category_repository)
    {
        $this->productRepository = $product_repository;
        $this->imageRepository = $image_repository;
        $this->categoryRepository = $category_repository;
    }

    public $name = '';
    public $slug = '';
    public $description = null;
    public $status = 'active';
    public $selectedCategories = [];
    public $image_ids = [];
    public $productId = null;

    public bool $openImageModal = false;
    public bool $openCategoryModal = false;

    public function rules()
    {
        return (new ProductRequest()->rules());
    }
    public function messages()
    {
        return (new ProductRequest()->messages());
    }

    public function createProduct()
    {
        $this->validate();
        $productData = $this->only([
            'name',
            'slug',
            'description',
            'status',
        ]);
        $productData['created_by'] = Auth::id();
        $product = $this->productRepository->create($productData);

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
        $this->productId = $product->id;

        session()->flash('message', 'Product is created successfully!');
        return redirect(route('admin.products'));
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
    #[Title('Create-Product')]
    public function render()
    {
        $categories = $this->categoryRepository->find($this->selectedCategories)->pluck('name')->toArray();
        $images = $this->imageRepository->find(function (&$query) {
            $query->whereIn('id', $this->image_ids)
                ->when($this->image_ids, fn($innerQuery) => $innerQuery->orderByRaw('FIELD(id, ' . implode(',', $this->image_ids) . ')'));
        }, [], true);
        return view('admin.pages.product.create', compact('images','categories'));
    }
}
