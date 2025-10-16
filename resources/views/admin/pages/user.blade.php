<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="filter-card p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        Search
                    </label>
                    <div class="input-group" >
                        <input type="text" class="form-control" placeholder="Tìm theo tên, email..." wire:model="search">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                        Role
                    </label>
                    <select class="form-select" wire:model="filter.role">
                        <option value="" selected>All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 6v6l4 2"></path>
                        </svg>
                        Status
                    </label>
                    <select class="form-select" wire:model="filter.status">
                        <option value="" selected>Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="btnSearch" class="btn btn-secondary w-100">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        Search
                    </button>
                </div>
            </div>
        </div>


    <!-- User table -->
    <div class="table-responsive">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary">User List</h5>
                <button class="btn btn-secondary" wire:click="openCreateModal">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add User
                </button>
            </div>
        <table class="table border mb-0">
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
                                    alt="user@email.com"><span class="avatar-status bg-success"></span></div>
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
                            <div class="text-nowrap">{{ $user->created_at }}</div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg class="icon">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options">
                                        </use>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" wire:click="openEditModal({{ $user->id }})">Edit</a>
                                    <a class="dropdown-item text-danger" wire:click="deleteUser({{ $user->id }})"
                                        wire:confirm="Are you sure you want to delete this user">Delete</a></div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Không có người dùng nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($showCreateModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
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
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
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


    <div class="mt-4">
        {{ $this->users->onEachSide(1)->links() }}
    </div>
    {{-- <div class="mt-4">
        {{ $users->links() }}
    </div> --}}
</div>
