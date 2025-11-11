<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow-sm rounded mb-4">
        <livewire:admin.components.search-filter :filterConfigs="$blogFiltersConfig" placeholderSearch="Search by name" />
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-box-seam"></i> Blog List
                </h3>
                <a class="btn btn-primary-custom" href="{{ route('admin.create_blog') }}">
                    <i class="bi bi-plus-circle"></i> + Add Blog
                </a>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>#</th>
                                <th>Blog</th>
                                <th>User</th>
                                <th>Tag</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->blogs as $blog)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Title: {{ Str::limit($blog->title, 40) }}
                                            <span class="copy-icon" onclick="copyToClipboard('{{ $blog->title }}')"
                                                title="Copy blog">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                    <path
                                                        d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="small text-body-secondary text-nowrap">#MAIL-{{ $blog->id }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $blog->user->first_name }}
                                            {{ $blog->user->last_name }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $blog->user->username }}</span>
                                            <span class="copy-icon"
                                                onclick="copyToClipboard('{{ $blog->user->username }}')"
                                                title="Copy blog">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                    <path
                                                        d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="small text-body-secondary text-nowrap">
                                            {{ $blog->user->email }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($blog->categories->isNotEmpty())
                                            @foreach ($blog->categories as $category)
                                                <span class="badge bg-success">{{ $category->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Not Exists Any Category</span>
                                        @endif
                                    </td>


                                    <td>
                                        <div>{{ $blog->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $blog->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a title="Edit" class="btn btn-sm btn-info btn-action"
                                                href="{{ route('admin.edit_blog', ['editingBlogId' => $blog->id]) }}"><svg
                                                    style="width: 20px;height: 20px;  stroke: currentColor; fill: currentColor; ">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-airplay">
                                                    </use>
                                                </svg></a>
                                            <button class="btn btn-sm btn-danger btn-action" title="Delete"
                                                wire:click="confirmDelete({{ $blog->id }})">
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
        {{ $this->blogs->onEachSide(1)->links() }}
    </div>
</div>
