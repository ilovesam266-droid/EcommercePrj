<div>
    <div class="flex flex-wrap gap-2 mb-4 items-center">

        <!-- Search box -->
        <input type="text" wire:model.debounce.300ms="search" placeholder="Tìm kiếm tên, username hoặc email..."
            class="border rounded p-2 flex-1" />

        <!-- Filter role -->
        {{-- <select wire:model="role" class="border rounded p-2">
            <option value="">Tất cả vai trò</option>
            @foreach ($roles as $roleItem)
                <option value="{{ $roleItem->value }}">{{ ucfirst($roleItem->value) }}</option>
            @endforeach
        </select>

        <!-- Filter status -->
        <select wire:model="status" class="border rounded p-2">
            <option value="">Tất cả trạng thái</option>
            @foreach ($statuses as $statusItem)
                <option value="{{ $statusItem->value }}">{{ ucfirst($statusItem->value) }}</option>
            @endforeach
        </select> --}}
        {{-- Nút Search --}}
        <div class="col-auto">
            <button wire:click="applySearch" class="btn btn-primary">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </div>
</div>
