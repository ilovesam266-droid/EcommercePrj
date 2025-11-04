<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected UserRepositoryInterface $userRepository;
    public string $search = '';
    public array $filter = [
        'status' => '',
        'role' => '',
    ];
    public array $sort = ['created_at' => 'asc'];
    public int $perPage = 5;
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public $editingUserId = null;

    protected $listener = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh',
    ];

    public function boot(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    //search & filter feature
    //fix to component search & filter
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

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function hideCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function openEditModal($userId)
    {
        $this->editingUserId = $userId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingUserId']); // Xóa ID người dùng đang chỉnh sửa
    }

    public function deleteUser($userId)
    {
        return $this->userRepository->delete($userId);
    }

    #[Computed()]
    public function users()
    {
        return $this->userRepository->all(
            $this->userRepository->getFilteredUsers($this->filter, $this->search),
            $this->sort,
            $this->perPage,
            ['*'],
            [],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Dashboard')]
    public function render()
    {
        $userFiltersConfig = [
            ['key' => 'role', 'placeholder' => 'Filter by Role', 'options' => [
                ['label' => 'Admin', 'value' => 'admin'],
                ['label' => 'User', 'value' => 'user']
            ]],
            ['key' => 'status', 'placeholder' => 'Filter by Status', 'options' => [
                ['label' => 'Active', 'value' => 'active'],
                ['label' => 'Inactive', 'value' => 'inactive'],
            ]],
        ];
        return view('admin.pages.user', compact('userFiltersConfig'));
    }
}
