<?php

namespace App\Livewire\Admin\Category;

use App\Http\Requests\CategoryRequest;
use App\Repository\Constracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateCategory extends Component
{
    protected CategoryRepositoryInterface $categoryRepository;
    public $name = '';
    public $slug = '';
    protected CategoryRequest $categoryRequest;

    public function __construct()
    {
        $this->categoryRequest = new CategoryRequest();
    }

    public function boot(CategoryRepositoryInterface $category_repository){
        $this->categoryRepository = $category_repository;
    }

    public function rules()
    {
        return $this->categoryRequest->rules();
    }

    public function messages()
    {
        return $this->categoryRequest->messages();
    }

    public function createCategory()
    {
        $this->validate();

        $categoryData = $this->only([
            'name', 'slug',
        ]);
        $categoryData['created_by'] = Auth::id();

        $category = $this->categoryRepository->create($categoryData);

        if ($category) {
            $this->reset();
            $this->dispatch('categoryCreated');
            $this->dispatch('showToast', 'success', 'Success', 'Category is created successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Category is created failed!');
        }
    }

    public function render()
    {
        return view('admin.pages.category.create');
    }
}
