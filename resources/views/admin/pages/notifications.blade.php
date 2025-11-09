<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-box-seam"></i> Notification List
                </h3>
                <a class="btn btn-primary-custom" href="{{ route('admin.create_notification') }}">
                    <i class="bi bi-plus-circle"></i>  + Add Notification
                </a>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>Notification</th>
                                <th>Category</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->notifications as $notification)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">Title: {{ $notification->title }}</div>
                                        <div class="small text-body-secondary text-nowrap">#NOTIFICATION-{{ $notification->id }}
                                        </div>
                                    </td>
                                    <td><span
                                            class="status-badge {{ $notification->type->colorClass() }}">{{ $notification->type }}</span>
                                    </td>
                                    <td>
                                        <p>{{ Str::before($notification->body, '. ') }}...</p>
                                    </td>
                                    <td>
                                        <div>{{ $notification->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $notification->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a title="Sửa" class="btn btn-sm btn-info btn-action"
                                                href="{{ route('admin.edit_notification', ['editingNotificationId' => $notification->id]) }}"><svg
                                                    style="width: 20px;height: 20px;  stroke: currentColor; fill: currentColor; ">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-airplay">
                                                    </use>
                                                </svg></a>
                                            {{-- <button class="btn btn-sm btn-danger btn-action" title="Xóa">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                    </use>
                                                </svg>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->notifications->onEachSide(1)->links() }}
    </div>
</div>
