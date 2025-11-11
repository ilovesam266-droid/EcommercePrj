<div class="container-lg">
    <div class="container-main">

        <!-- Header -->
        <div class="card shadow-sm rounded mb-4">
            <livewire:admin.components.search-filter :filterConfigs="$productFiltersConfig" placeholderSearch="Search by name" />
        </div>
        <div class='card shadow-sm rounded'>
            <div class="table-responsive">
                <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="bi bi-box-seam"></i> Product List
                    </h3>
                    <a href="{{ route('admin.create_product') }}" class="btn btn-primary-custom">
                        <i class="bi bi-plus-circle"></i> + Add Product
                    </a>
                </div>
                <div class="p-4">
                    <div class="rounded-3 overflow-hidden border">
                        <table class="table table-hover border mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th class="bg-body-secondary text-center">
                                        <svg class="icon">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-3d"></use>
                                        </svg>
                                    </th>
                                    <th>Product</th>
                                    <th style="width: 25%">User</th>
                                    <th style="width: 25%">Category</th>
                                    <th style="width: 30%">Description</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->products as $product)
                                    <!-- Product 1 -->
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="avatar avatar-md">
                                                @if ($product->images->count() > 0)
                                                    <img class="avatar-img" style="width: flex"
                                                        src="{{ asset('storage/' . $product->images->first()->url) }}"
                                                        alt="">
                                                @else
                                                    <img class="avatar-img" style="width: 70px"
                                                        src="{{ asset('storage/products/PluNzUha2Q50b1aRmTGByWjCh0vpy6ef1sM0yGUp.jpg') }}"
                                                        alt="">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-nowrap">{{ $product->name }}--Rating:
                                                {{ number_format($product->averageRating(), 1) }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>#PRODUCT-{{ $product->id }}</span> |
                                                Created At:
                                                {{ $product->created_at->format('d/m/Y') ?? 'Not updated yet' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-nowrap">{{ $product->creator->first_name }}
                                                {{ $product->creator->last_name }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>{{ $product->creator->username }}</span>
                                                <span class="copy-icon"
                                                    onclick="copyToClipboard('{{ $product->creator->username }}')"
                                                    title="Copy product">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                        <path
                                                            d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="small text-body-secondary text-nowrap">
                                                {{ $product->creator->email }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($product->categories->isNotEmpty())
                                                @foreach ($product->categories as $category)
                                                    <span class="badge bg-success">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Not Exists Any Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($product->description, 20) }}</small>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $product->status->colorClass() }} status-badge">{{ $product->status }}</span>
                                        </td>
                                        <div>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.edit_product', ['editingProductId' => $product->id]) }}"
                                                        class="btn btn-sm btn-warning btn-action">
                                                        <i class="bi bi-pencil">
                                                            <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                                <use
                                                                    xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger btn-action"
                                                        wire:click="confirmDelete({{ $product->id }})">
                                                        <i class="bi bi-pencil">
                                                            <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                                <use
                                                                    xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </button>
                                                </div>
                                        </div>
                                    </tr>
                                @empty
                                    <p>Have not any image exist.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <livewire:admin.components.modal-confirm />
        <div class="mt-4">
            {{ $this->products->onEachSide(1)->links() }}
        </div>
    </div>
</div>
