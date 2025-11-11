<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm rounded mb-4">
        <livewire:admin.components.search-filter :filterConfigs="$commentFiltersConfig" placeholderSearch="Search by user or blog" />
    </div>
    <!-- Comments Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-chat-left-text-fill"></i> Comment List
                </h3>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Blog</th>
                                <th>Content</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->comments as $comment)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $comment->user->fullname }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $comment->user->username }}</span>
                                        </div>
                                        <div class="small text-body-secondary text-nowrap">{{ $comment->user->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ Str::limit($comment->blog->title ?? 'No content', 20) }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>Slug: {{ $comment->blog->slug ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ Str::limit($comment->content ?? 'No content', 20) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($comment->parent_id)
                                            <span class="badge bg-info">
                                                <i class="bi bi-reply-fill"></i> Reply
                                            </span>
                                        @else
                                            <span class="badge bg-primary">
                                                <i class="bi bi-chat-fill"></i> Comment
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $comment->status->colorClass() }}">
                                            {{ $comment->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $comment->created_at->format('d/m/Y') }}</div>
                                        <small
                                            style="color: #718096;">{{ $comment->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($comment->status !== 'approved')
                                                <button class="btn btn-sm btn-success btn-action" title="Approve"
                                                    wire:click="approveComment({{ $comment->id }})">
                                                    <svg class="icon">
                                                        <use
                                                            xlink:href="vendors/@coreui/icons/svg/free.svg#cil-thumb-up">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                            @if ($comment->status !== 'rejected')
                                                <button class="btn btn-sm btn-warning btn-action" title="Reject"
                                                    wire:click="rejectComment({{ $comment->id }})">
                                                    <svg class="icon">
                                                        <use
                                                            xlink:href="vendors/@coreui/icons/svg/free.svg#cil-thumb-down">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger btn-action" title="Delete"
                                                wire:click="confirmDelete({{ $comment->id }})">
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
    </div>
    <livewire:admin.components.modal-confirm />
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->comments->onEachSide(1)->links() }}
    </div>
</div>
