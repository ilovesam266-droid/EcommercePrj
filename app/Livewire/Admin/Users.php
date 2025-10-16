<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected UserRepositoryInterface $userRepository;

    public array $filter = [
        'status' => '',
        'role' => '',
    ];

    public string $search = '';

    public array $sort = ['created_at' => 'asc'];

    public int $perPage = 5;

    public bool $showCreateModal = false;

    public $editingUserId = null;

    public bool $showEditModal = false;

    public string $newStatus, $newRole;

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
    protected function buildUser()
    {
        return function ($query) {
            if (isset($this->filter) && $this->filter['status'] != '' || $this->filter['role'] != '') {
                $this->userRepository->buildCriteria($query, $this->filter);
            }

            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%') // Use first_name
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')  // Use last_name
                        ->orWhere('username', 'like', '%' . $this->search . '%') // Use username
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            };
        };
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

    public function deleteUser($userId){
        return $this->userRepository->delete($userId);
    }

    //after search
    public function btnSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function users()
    {
        return $this->userRepository->all(
            $this->buildUser(),
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
        return view('admin.pages.user');
    }
}
