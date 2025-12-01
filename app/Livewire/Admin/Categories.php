<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\CategoryRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    protected CategoryRepositoryInterface $categoryRepository;
    public int $perPage;
    public $sort;
    public string $search = '';
    public array $filter = [];
    public string $currentTab = 'product';
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public $editingCategoryId = null;

    protected $listener = [
        'categoryCreated' => '$refresh',
        'categoryUpdated' => '$refresh',
        'categoryDeleted' => '$refresh',
    ];

    public function boot(CategoryRepositoryInterface $category_repository)
    {
        $this->categoryRepository = $category_repository;
    }

    public function mount()
    {
        $this->sort = config('app.sort');
        $this->perPage = config('app.per_page');
    }

    #[On('searchPerformed')]
    public function updatedSearchTemp($searchTemp)
    {
        $this->search = $searchTemp;
    }

    #[On('resetPage')]
    public function Search()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function hideCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function openEditModal($categoryId)
    {
        $this->editingCategoryId = $categoryId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingCategoryId']); // Xóa ID người dùng đang chỉnh sửa
    }

    public function confirmDelete($categoryId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm category deletion',
            'Are you sure you want to delete this category <<' . $categoryId . '>>?',
            'delete-category',
            ['category_id' => $categoryId],
        );
    }

    #[On('delete-category')]
    public function deletecategory($data)
    {
        $categoryId = $data['category_id'];
        $this->categoryRepository->delete($categoryId);
        $this->dispatch('categoryDeleted');
    }

    #[Computed()]
    public function categories()
    {
        return $this->categoryRepository->getAllCategories($this->perPage, $this->sort, $this->filter, $this->search);
    }

    #[Layout('layouts.page-layout')]
    #[Title('Categories')]
    public function render()
    {
        $categoryFiltersConfig = [];

        $totalCategories = $this->categoryRepository->totalCategories();
        $totalAssignments = $this->categoryRepository->totalCategoryables();
        $unusedCategories = $this->categoryRepository->unusedCategories();
        $topCategory = $this->categoryRepository->topAssignedCategory();

        return view('admin.pages.categories', compact('categoryFiltersConfig', 'totalCategories', 'totalAssignments', 'unusedCategories', 'topCategory'));
    }
}
