<div class="container-lg">
    <div class="container-main">

        <!-- Header -->
        <div class="header-section">
        </div>
        <div class='card shadow-sm rounded'>
            <div class="table-responsive text-center align-middle">
                <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-secondary">
                        <i class="bi bi-box-seam"></i> Product Management
                    </h4>
                    <a href="{{ route('admin.create_product') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                </div>
                <div class="p-4">
                    <div class="rounded-3 overflow-hidden border">
                        <table class="table table-hover border mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 10%">Image</th>
                                    <th style="width: 25%">Product Name</th>
                                    <th style="width: 25%">Category Name</th>
                                    <th style="width: 30%">Description</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->products as $product)
                                    <!-- Product 1 -->
                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">{{ $product->id }}</div>
                                        </td>
                                        <td class="text-center">
                                            @if ($product->images->count() > 0)
                                                <img style="width: 70px"
                                                    src="{{ asset('storage/' . $product->images->first()->url) }}"
                                                    alt="">
                                            @else
                                                <img style="width: 70px"
                                                    src="{{ asset('storage/products/PluNzUha2Q50b1aRmTGByWjCh0vpy6ef1sM0yGUp.jpg') }}"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $product->id }}</small>
                                        </td>
                                        <td>
                                            @if ($product->categories->isNotEmpty())
                                                @foreach ($product->categories as $category)
                                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Not Exists Any Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $product->description }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success status-badge">{{ $product->status }}</span>
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
                                                        wire:click="deleteProduct({{ $product->id }})"
                                                        wire:confirm="Are you sure you want to delete this product?">
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
                                    <p>Chưa có ảnh nào được tải lên.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $this->products->onEachSide(1)->links() }}
        </div>
    </div>
</div>
