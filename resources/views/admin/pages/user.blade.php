<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm rounded mb-4">
        <livewire:admin.components.search-filter :filterConfigs="$userFiltersConfig" placeholderSearch="Search by name" />
    </div>


    <!-- User table -->
    <div class='card shadow-sm rounded'>
        <div class="table-responsive text-center align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-secondary">User List</h4>
                <button class="btn btn-secondary" wire:click="openCreateModal">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add User
                </button>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="bg-body-secondary">#</th>
                                <th class="bg-body-secondary text-center">
                                    <svg class="icon">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                                    </svg>
                                </th>
                                <th class="bg-body-secondary">Name</th>
                                <th class="bg-body-secondary">Username</th>
                                <th class="bg-body-secondary">Email</th>
                                <th class="bg-body-secondary">Role</th>
                                <th class="bg-body-secondary">Status</th>
                                <th class="bg-body-secondary">Created_at</th>
                                <th class="bg-body-secondary">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($this->users as $user)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">{{ $user->id }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="avatar avatar-md"><img class="avatar-img" src="{{ $user->avatar }}"
                                                {{-- src="{{ asset('storage/'.$user->avatar) }}" --}} alt="user@email.com"><span
                                                class="avatar-status bg-success"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->full_name }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->username }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->role }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->status }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $user->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-warning btn-action"
                                                wire:click="openEditModal({{ $user->id }})">
                                                <i class="bi bi-pencil">
                                                    <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                        </use>
                                                    </svg>
                                                </i>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action"
                                                wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="Are you sure you want to delete this user">
                                                <i class="bi bi-pencil">
                                                    <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                        </use>
                                                    </svg>
                                                </i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">Không có người dùng nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($showCreateModal)
                <div class="modal fade show d-block" tabindex="-1" role="dialog"
                    style="background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tạo Người dùng mới</h5>
                                <button type="button" class="btn-close" wire:click="hideCreateModal"></button>
                            </div>
                            <div class="modal-body">
                                <livewire:Admin.User.create-user />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($showEditModal && $editingUserId)
                <div class="modal fade show d-block" tabindex="-1" role="dialog"
                    style="background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa Người dùng</h5>
                                <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Nhúng component EditUser và truyền ID người dùng --}}
                                <livewire:Admin.User.edit-user :user-id="$editingUserId" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->users->onEachSide(1)->links() }}
    </div>
</div>
