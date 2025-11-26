<?php

namespace App\Livewire\Admin;

use App\Enums\UserStatus;
use App\Repository\Constracts\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected UserService $service;
    public string $search = '';
    public array $filter = [
        'status' => '',
        'role' => '',
    ];
    public $sort;
    public $perPage;
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public $editingUserId = null;

    protected $listener = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh',
    ];

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->sort = config('app.sort');
        $this->perPage = config('app.per_page');
    }

    //switch user status
    public function toggleStatus($userId)
    {
        $status = $this->service->toggleStatus((int)$userId);

        if ($status) {
            $this->dispatch('showToast', 'success', 'Success', "User has been updated {$status}");
        }else{
            $this->dispatch('showToast', 'error', 'Error', "User has been updated failed");
        }
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

    // modal create user
    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function hideCreateModal()
    {
        $this->showCreateModal = false;
    }

    //modal edit user
    public function openEditModal($userId)
    {
        $this->editingUserId = $userId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingUserId']);
    }

    //delete user
    public function confirmDelete($userId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm user deletion',
            'Are you sure you want to delete this user <<' . $userId . '>>?',
            'delete-user',
            ['user_id' => $userId],
        );
    }

    #[On('delete-user')]
    public function deleteUser($data)
    {
        $userId = $data['user_id'];
        try {
            $this->service->deleteUser($userId);
            $this->dispatch('userDeleted');
        } catch (QueryException $e) {
            $this->dispatch('showToast', 'error', 'Error', 'User is used in other places');
        }
    }

    #[Computed()]
    public function users()
    {
        return $this->service->getUsers($this->perPage, $this->sort, $this->search, $this->filter);
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
        $totalActiveUsers = $this->service->countActive();
        $usersNeedingAttention = $this->service->countNeedingAttention();

        return view('admin.pages.user', compact('userFiltersConfig', 'totalActiveUsers', 'usersNeedingAttention'));
    }
}
