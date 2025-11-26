<div>
    <div>
        <div class="row g-4 mb-4">
            <div class="row g-3">

                <livewire:admin.components.dashboard-widget :title="'Total Products'" :value="$this->products->total()" :color="'primary'"
                    :icon="'vendors/@coreui/icons/svg/free.svg#cil-tags'" :chartId="'card-product-total'" :dropdownItems="['All']" />

                <livewire:admin.components.dashboard-widget :title="'Total Stock'" :value="$totalStock" :subtext="' items'"
                    :color="'success'" :icon="'vendors/@coreui/icons/svg/free.svg#cil-layers'" :chartId="'card-stock-total'" :dropdownItems="['All Stock']" />

                <livewire:admin.components.dashboard-widget :title="'Out of Stock'" :value="$outOfStockCount" :color="'danger'"
                    :icon="'vendors/@coreui/icons/svg/free.svg#cil-warning'" :chartId="'card-out-stock'" :dropdownItems="['0 Stock']" />

                <livewire:admin.components.dashboard-widget :title="'Low Stock'" :value="$lowStockCount" :color="'warning'"
                    :icon="'vendors/@coreui/icons/svg/free.svg#cil-chart-line'" :chartId="'card-low-stock'" :dropdownItems="['< 5', '< 10', '< 20']" />

            </div>
        </div>
    </div>

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
                                    <th style="width:30%">Product</th>
                                    <th style="width:25%">Category</th>
                                    <th style="width:10%">Stock</th>
                                    <th style="width:10%">Status</th>
                                    <th style="width:15%">User</th>
                                    <th style="width:10%">Action</th>
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
                                                    <img class="avatar-img" style="width: flex"
                                                        src="{{ asset('storage/products/e88a5f1d3aafe0b2939c298687adbab0.jpg') }}"
                                                        alt="">
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <div class="text-truncate fw-medium">{{ $product->name }}--Rating:
                                                {{ number_format($product->averageRating(), 1) }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>#PRODUCT-{{ $product->id }}</span> |
                                                Created At:
                                                {{ $product->created_at->format('d/m/Y') ?? 'Not updated yet' }}
                                            </div>
                                        </td>

                                        <td>
                                            @if ($product->categories->isNotEmpty())
                                                {{-- Hiển thị 3 danh mục đầu --}}
                                                @foreach ($product->categories->take(2) as $category)
                                                    <span class="badge bg-success">{{ $category->name }}</span>
                                                @endforeach

                                                {{-- Nếu có nhiều hơn 3 --}}
                                                @if ($product->categories->count() > 2)
                                                    @php
                                                        $collapseId = 'categories-' . $product->id;
                                                    @endphp

                                                    <a data-bs-target="#{{ $collapseId }}" data-bs-toggle="collapse"
                                                        class="small text-body-secondary text-nowrap d-block mt-1">
                                                        View more ({{ $product->categories->count() - 2 }})
                                                    </a>

                                                    <div class="collapse mt-1" id="{{ $collapseId }}">
                                                        @foreach ($product->categories->slice(2) as $category)
                                                            <span class="badge bg-success">{{ $category->name }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">Not Exists Any Category</span>
                                            @endif
                                        </td>


                                        <td>
                                            @php $status = $product->stockStatus(); @endphp

                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">
                                                    {{ $product->sumStock() }}
                                                </span>

                                                <span class="{{ $status['class'] }} small d-flex align-items-center">
                                                    <span class="me-1"
                                                        style="font-size: 10px;">{{ $status['dot'] }}</span>
                                                    {{ $status['label'] }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <span
                                                class="badge {{ $product->status->colorClass() }} status-badge">{{ $product->status }}</span>
                                        </td>


                                        <td>
                                            <div class="text-truncate fw-medium">
                                                {{ $product->creator->first_name }}
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


                                        <div>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.edit_product', ['editingProductId' => $product->id]) }}"
                                                        class="btn btn-sm btn-warning btn-action">
                                                        <i class="bi bi-pencil">
                                                            <svg class="nav-icon text-white"
                                                                style="width: 20px;height: 20px;">
                                                                <use
                                                                    xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger btn-action"
                                                        wire:click="confirmDelete({{ $product->id }})">
                                                        <i class="bi bi-pencil">
                                                            <svg class="nav-icon text-white"
                                                                style="width: 20px;height: 20px;">
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
