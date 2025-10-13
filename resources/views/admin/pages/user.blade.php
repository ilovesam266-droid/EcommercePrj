<div class="p-4 bg-white rounded shadow">

    <div class="flex flex-wrap gap-2 mb-4 items-center">
        <!-- Search box -->
        {{-- <input
            type="text"
            wire:model.debounce.300ms="search"
            placeholder="Tìm kiếm tên, username hoặc email..."
            class="border rounded p-2 flex-1"
        /> --}}

        <!-- Filter role -->
        {{-- <select wire:model="role" class="border rounded p-2">
            <option value="">Tất cả vai trò</option>
            @foreach($roles as $roleItem)
                <option value="{{ $roleItem->value }}">{{ ucfirst($roleItem->value) }}</option>
            @endforeach
        </select>

        <!-- Filter status -->
        <select wire:model="status" class="border rounded p-2">
            <option value="">Tất cả trạng thái</option>
            @foreach($statuses as $statusItem)
                <option value="{{ $statusItem->value }}">{{ ucfirst($statusItem->value) }}</option>
            @endforeach
        </select> --}}
    </div>

    <!-- User table -->
    <table class="w-full border-collapse border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">#</th>
                <th class="border p-2 text-left">Name</th>
                <th class="border p-2 text-left">Username</th>
                <th class="border p-2 text-left">Email</th>
                <th class="border p-2 text-left">Role</th>
                <th class="border p-2 text-left">Status</th>
                <th class="border p-2 text-left">Created_at</th>
            </tr>
        </thead>
        <tbody>
            @forelse($this->users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $user->id }}</td>
                    <td class="p-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="p-2">{{ $user->username }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 capitalize">{{ $user->role }}</td>
                    <td class="p-2">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->status }}
                        </span>
                    </td>
                    <td class="p-2">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">Không có người dùng nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- <div class="mt-4">
        {{ $users->links() }}
    </div> --}}
</div>
