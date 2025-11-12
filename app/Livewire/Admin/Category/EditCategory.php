<?php

namespace App\Livewire\Admin\Category;

use App\Http\Requests\CategoryRequest;
use App\Repository\Constracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditCategory extends Component
{

    protected CategoryRepositoryInterface $categoryRepository;
    public $name = '';
    public $slug = '';
    public $categoryId;
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
        return $this->categoryRequest->rules('edit', $this->categoryId);
    }

    public function messages()
    {
        return $this->categoryRequest->messages();
    }

    public function mount($categoryId){
        $this->categoryId = $categoryId;
        $this->loadCategory();

    }

    public function loadCategory(){
        $category = $this->categoryRepository->find($this->categoryId);
        if($category){
            $this->fill($category->only([
                'name', 'slug',
            ]));
        } else {
            $this->dispatch('showToast', 'error', 'Error','No category found to edit.');
            $this->dispatch('userUpdated');
        }
    }

    public function editCategory()
    {
        $this->validate();

        $categoryData = $this->only([
            'name', 'slug',
        ]);

        $category = $this->categoryRepository->update($this->categoryId, $categoryData);

        if ($category) {
            $this->reset();
            $this->dispatch('categoryCreated');
            $this->dispatch('showToast', 'success', 'Success', 'Category is updated successfully!');
            return redirect()->route('admin.categories');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Category is updated failed!');
        }
    }

    public function render()
    {
        return view('admin.pages.category.edit');
    }
}
