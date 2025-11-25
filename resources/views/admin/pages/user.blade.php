<div>
    <div class="row g-3 mb-4">
        <div class="row g-3 justify-content-center">
            <!-- 1) Total Users -->
            <livewire:admin.components.dashboard-widget :title="'Users'" :value="$this->users->total()" :color="'primary'"
                :icon="'vendors/@coreui/icons/svg/free.svg#cil-user'" :chartId="'card-total-users'" :dropdownItems="['All']" />

            <!-- 2) Active Users -->
            <livewire:admin.components.dashboard-widget :title="'Active Users'" :value="$totalActiveUsers" :subtext="round(($totalActiveUsers / $this->users->total()) * 100, 1) . '%'"
                :color="'success'" :icon="'vendors/@coreui/icons/svg/free.svg#cil-check-circle'" :chartId="'card-active-users'" :dropdownItems="['Active']" />

            <!-- 3) Users Needing Attention -->
            <livewire:admin.components.dashboard-widget :title="'Needs Attention'" :value="$usersNeedingAttention" :color="'warning'"
                :icon="'vendors/@coreui/icons/svg/free.svg#cil-warning'" :chartId="'card-users-warning'" :dropdownItems="['Incomplete Profile']" />
        </div>
    </div>

    <div class="p-4 bg-white rounded shadow-lg">
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
            <div class="table-responsive align-middle">
                <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">User List</h3>
                    <button class="btn btn-primary-custom" wire:click="openCreateModal">
                        + Add User
                    </button>
                </div>
                <div class="p-4">
                    <div class="rounded-3 overflow-hidden border">
                        <table class="table table-hover border mb-0">
                            <thead class="table-light align-middle centered-cell">
                                <tr>
                                    <th>#</th>
                                    <th class="bg-body-secondary text-center">
                                        <svg class="icon">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                                        </svg>
                                    </th>
                                    <th>User</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($this->users as $user)
                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">{{ $loop->iteration }}</div>
                                        </td>
                                        <td>
                                            <div class="avatar avatar-md"><img class="avatar-img" {{-- src="{{ $user->avatar }}" --}}
                                                    src="{{ asset('storage/' . $user->avatar) }}" alt="o"><span
                                                    class="avatar-status bg-success"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate fw-medium" style="max-width: 420px;">
                                                {{ $user->full_name }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>{{ $user->email }}</span><span class="copy-icon"
                                                    onclick="copyToClipboard('{{ $user->email }}')"
                                                    title="Copy user">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                        <path
                                                            d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                    </svg>
                                                </span>

                                            </div>
                                            <div class="small text-body-secondary text-nowrap">
                                             Birthday:
                                                {{ optional($user->birthday)->format('d/m/Y') ?? 'Not updated yet' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($user->defaultAddress())
                                                <div class="text-truncate fw-medium" style="max-width: 420px;">
                                                    {{ Str::limit($user->defaultAddress->detailed_address, 43) }}
                                                    <span class="copy-icon"
                                                        onclick="copyToClipboard(@js($user->defaultAddress->ward))"
                                                        title="Copy Address">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                            <path
                                                                d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                        </svg>
                                                    </span></div>
                                                <div class="small text-body-secondary">
                                                    {{ $user->defaultAddress->ward }},
                                                    {{ $user->defaultAddress->district }},
                                                    {{ $user->defaultAddress->province }}
                                                </div>
                                            @else
                                                <span class="text-muted">No default address</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge {{ $user->role->colorClass() }}">{{ $user->role }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch user-status-switch"
                                                data-user-id="{{ $user->id }}">
                                                <input class="form-check-input user-status-switch-input" type="checkbox"
                                                    role="switch" id="userStatusSwitch{{ $user->id }}"
                                                    wire:click="toggleStatus({{ $user->id }})"
                                                    {{ $user->status === \App\Enums\UserStatus::ACTIVE ? 'checked' : '' }}>
                                                <label class="form-check-label label-text"
                                                    for="userStatusSwitch{{ $user->id }}">
                                                    {{ $user->status->value === \App\Enums\UserStatus::ACTIVE->value ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                            <small
                                                style="color: #718096;">{{ $user->created_at->format('H:i:s') }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-warning btn-action"
                                                    wire:click="openEditModal({{ $user->id }})">
                                                    <svg class="nav-icon text-white" style="width: 20px;height: 20px;">
                                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                        </use>
                                                    </svg>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-action" {{-- wire:click="deleteUser({{ $user->id }})" --}}
                                                    wire:click="confirmDelete({{ $user->id }})">
                                                    <svg class="nav-icon text-white" style="width: 20px;height: 20px;">
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
                                    <button type="button" class="btn-close white"
                                        wire:click="hideCreateModal"></button>
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
                                        Edit user
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

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.body.addEventListener('click', e => {
            const input = e.target.closest('.user-status-switch-input');
            if (!input) return;

            const switchContainer = input.closest('.user-status-switch');
            if (!switchContainer) return;

            const label = switchContainer.querySelector('.label-text');
            if (!label) return;

            // Toggle ngay trên UI
            label.textContent = input.checked ? 'Active' : 'Inactive';
        });
    });
</script>
