<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm rounded mb-4">
        <livewire:admin.components.search-filter :filterConfigs="$addressFiltersConfig" placeholderSearch="Search by user or address" />
    </div>
    <!-- Address Users Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-geo-alt-fill"></i> User Address List
                </h3>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>#</th>
                                <th>Address</th>
                                <th>Recipient Info</th>
                                <th>User</th>
                                <th>Is Default</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->addresses as $address)
                                <tr class="align-middle">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            <div class="text-nowrap">{{ Str::limit($address->detailed_address, 30) }}
                                                <span class="copy-icon"
                                                onclick="copyToClipboard(@js($address->ward))"
                                                title="Copy Address">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                    <path
                                                        d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                </svg>
                                            </span>
                                            </div>

                                            <div class="small text-body-secondary">
                                                {{ $address->ward }}, {{ $address->district }},
                                                {{ $address->province }}
                                            </div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>#ADR-{{ $address->id }}</span> |
                                                Created At:
                                                {{ $address->created_at->format('d/m/Y') ?? 'Not updated yet' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $address->recipient_name }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <i class="bi bi-telephone"></i> {{ $address->recipient_phone }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $address->user->first_name }}
                                            {{ $address->user->last_name }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $address->user->username }}</span>
                                            <span class="copy-icon"
                                                onclick="copyToClipboard('{{ $address->user->username }}')"
                                                title="Copy Username">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                    <path
                                                        d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="small text-body-secondary text-nowrap">{{ $address->user->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch address-switch"
                                            data-user-id="{{ $address->user_id }}"
                                            data-address-id="{{ $address->id }}">
                                            <input class="form-check-input address-switch-input" type="checkbox"
                                                role="switch" id="defaultSwitch{{ $address->id }}"
                                                {{ $address->is_default ? 'checked disabled' : '' }}
                                                @if (!$address->is_default) wire:click="setAsDefault({{ $address->id }})" @endif>
                                            <label class="form-check-label" for="defaultSwitch{{ $address->id }}">
                                                <span class="label-text">
                                                    {{ $address->is_default ? 'Default Address' : 'Set as Default' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info btn-action" title="Edit"
                                                wire:click="openEditModal({{ $address->id }})">
                                                <svg class="icon">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                    </use>
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" title="Delete"
                                                wire:click="confirmDelete({{ $address->id }})">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($showEditModal && $editingAddressId)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeEditModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="text-white d-flex align-items-center gap-2">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" style="color: white">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Edit Address
                            </h3>
                            <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                        </div>

                        <div class="modal-body">
                            <livewire:Admin.Address.edit-address :address-id="$editingAddressId" />
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <livewire:admin.components.modal-confirm />
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->addresses->onEachSide(1)->links() }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.body;

        container.addEventListener('click', e => {
            const input = e.target.closest('.address-switch-input');
            if (!input || input.disabled) return;

            const userId = input.closest('.address-switch')?.dataset.userId;
            if (!userId) return;

            updateSwitchesUI(userId, input);
        });
    });

    function updateSwitchesUI(userId, clickedSwitch) {
        const switches = document.querySelectorAll(`[data-user-id="${userId}"] .address-switch-input`);

        switches.forEach(sw => {
            const labelText = sw.closest('.address-switch').querySelector('.label-text');
            const isClicked = sw === clickedSwitch;

            sw.checked = isClicked;
            sw.disabled = isClicked;
            if (labelText) labelText.textContent = isClicked ? 'Default Address' : 'Set as Default';
        });
    }
</script>
