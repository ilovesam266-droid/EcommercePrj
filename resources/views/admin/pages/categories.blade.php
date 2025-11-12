<div class="container-lg">
    <div class="container-main">

        <!-- Header -->
        <div class="card shadow-sm rounded mb-4">
            <livewire:admin.components.search-filter :filterConfigs="$categoryFiltersConfig" placeholderSearch="Search by name" />
        </div>

        <div class="card shadow-sm rounded">
            <div class="table-responsive">
                <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="bi bi-tags"></i> Category List
                    </h3>
                    <button class="btn btn-primary-custom" wire:click="openCreateModal">
                        + Add Category
                    </button>
                </div>
                <div class="p-4">
                    <div class="rounded-3 overflow-hidden border">
                        <table class="table table-hover border mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created By</th>
                                    <th>Product</th>
                                    <th>Blog</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->categories as $category)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}
                                            <div class="small text-muted">{{ $category->slug }}</div>
                                        </td>
                                        <td>
                                            {{ $category->creator->fullname }}
                                            <div class="small text-muted">{{ $category->creator->email }}</div>
                                            <div class="small text-muted">Created at:
                                                {{ $category->created_at->format('d/m/Y') }}</div>
                                        </td>
                                        <td>
                                            @if ($category->products->isNotEmpty())
                                                @foreach ($category->products->take(3) as $product)
                                                    <span
                                                        class="badge bg-primary">{{ Str::limit($product->name, 20) }}</span>
                                                @endforeach
                                                @if ($category->products->count() > 3)
                                                    <span class="text-muted">+{{ $category->products->count() - 3 }}
                                                        more</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No Products</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($category->blogs->isNotEmpty())
                                                @foreach ($category->blogs->take(3) as $blog)
                                                    <span
                                                        class="badge bg-warning">{{ Str::limit($blog->title, 20) }}</span>
                                                @endforeach
                                                @if ($category->blogs->count() > 3)
                                                    <span class="text-muted">+{{ $category->blogs->count() - 3 }}
                                                        more</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No Blogs</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-warning btn-action"
                                                    wire:click="openEditModal({{ $category->id }})">
                                                    <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                        </use>
                                                    </svg>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-action"
                                                    wire:click="confirmDelete({{ $category->id }})">
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
                                        <td colspan="6" class="text-center text-muted">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Add new category
                            </h3>
                            <button type="button" class="btn-close white" wire:click="hideCreateModal"></button>
                        </div>
                        <div class="modal-body">
                            <livewire:Admin.Category.create-category />
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($showEditModal && $editingCategoryId)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeEditModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="text-white">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" style="color: white">
                                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Edit category
                            </h3>
                            <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                        </div>
                        <div class="modal-body">
                            {{-- Nhúng component EditUser và truyền ID người dùng --}}
                            <livewire:Admin.Category.edit-category :category-id="$editingCategoryId" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <livewire:admin.components.modal-confirm />
    </div>
    <div class="mt-4">
        {{ $this->categories->onEachSide(1)->links() }}
    </div>
</div>
