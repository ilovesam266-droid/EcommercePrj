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
        <div class="table-responsive">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">User List</h3>
                <button class="btn btn-primary-custom" wire:click="openCreateModal">
                    + Add User
                </button>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="bg-dark">
                            <tr>
                                <th class="bg-body-secondary text-center">
                                    <svg class="icon">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                                    </svg>
                                </th>
                                <th class="bg-body-secondary">User</th>
                                <th class="bg-body-secondary">Email</th>
                                <th class="bg-body-secondary">Role</th>
                                <th class="bg-body-secondary">Status</th>
                                <th class="bg-body-secondary">Created At</th>
                                <th class="bg-body-secondary">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($this->users as $user)
                                <tr>
                                    <td>
                                        <div class="avatar avatar-md"><img class="avatar-img" src="{{ $user->avatar }}"
                                                {{-- src="{{ asset('storage/'.$user->avatar) }}" --}} alt="user@email.com"><span
                                                class="avatar-status bg-success"></span></div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->full_name }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $user->username }}</span> |
                                            Birthday:
                                            {{ optional($user->birthday)->format('d/m/Y') ?? 'Not updated yet' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <span
                                            class="status-badge {{ $user->role->colorClass() }}">{{ $user->role }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="status-badge {{ $user->status->colorClass() }}">{{ $user->status }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $user->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-warning btn-action"
                                                wire:click="openEditModal({{ $user->id }})">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                    </use>
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action"
                                                {{-- wire:click="deleteUser({{ $user->id }})" --}}
                                                wire:click="confirmDelete({{ $user->id }})">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                    </use>
                                                </svg>
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
                    style="background-color: rgba(0,0,0,0.5);" wire:click.self="hideCreateModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header card-header">
                                <h3 class="text-white">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="8" r="4" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" />
                                        <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Add new user
                                </h3>
                                <button type="button" class="btn-close white" wire:click="hideCreateModal"></button>
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
                    style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeEditModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="text-white">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" style="color: white">
                                        <circle cx="12" cy="8" r="4" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" />
                                        <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Add new user
                                </h3>
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
    <livewire:admin.components.modal-confirm />
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->users->onEachSide(1)->links() }}
    </div>
</div>
