<div class="variant-table">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="section-title mb-0">Product Variant</h3>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#variantModal"
            wire:click="showCreateVariantModal">
            + Add Product Variant
        </button>
    </div>

    <div class="table-responsive rounded-3 border-3">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Id</th>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>Total Sold</th>
                    <th>Stock</th>
                    <th>Created At</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->product_variants as $productVariant)
                    <tr class="align-middle">
                        <td>
                            {{ $productVariant->id }}
                        </td>
                        <td>
                            <strong><span class="variant">{{ $productVariant->variant_size }}</span></strong>
                        </td>
                        <td>
                            <strong>{{ number_format($productVariant->price, 0, ',', '.') }} ₫</strong>
                        </td>
                        <td>
                            <small>
                                {{ $productVariant->total_sold }}
                            </small>
                        </td>
                        <td>
                            <small
                                style="color: {{ $productVariant->stock > 50 ? '#10b981' : '#ef4444' }}; font-weight: 600;">
                                {{ $productVariant->stock }}
                            </small>
                        </td>
                        <td>
                            <div>{{ $productVariant->created_at->format('d/m/Y') }}</div>
                            <small style="color: #718096;">{{ $productVariant->created_at->format('H:i:s') }}</small>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-warning btn-action"
                                wire:click="showEditVariantModal({{ $productVariant->id }})">
                                <i class="bi bi-pencil">
                                    <svg class="nav-icon" style="width: 20px;height: 20px;">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                                    </svg>
                                </i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-action"
                                wire:click="deleteVariant({{ $productVariant->id }})"
                                wire:confirm="Are you sure you want to delete this user?">
                                <i class="bi bi-pencil">
                                    <svg class="nav-icon" style="width: 20px;height: 20px;">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                                    </svg>
                                </i>
                            </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="7" class="text-center" style="padding: 60px 20px;">
                        <div class="empty-state">
                            <div class="empty-state-icon" style="font-size: 48px; margin-bottom: 16px;">📋</div>
                            <p style="color: #718096; font-size: 16px; margin: 0;">Chưa có biến thể nào. Hãy thêm biến thể đầu tiên!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($openCreateVariantModal)
        <!-- Modal Thêm Biến Thể -->
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Biến Thể Sản Phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            wire:click="hideCreateVariantModal"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:admin.product-variant.create-product-variant :product_id="$productId" />
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($openEditVariantModal && $productVariantId)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa Biến Thể Sản Phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            wire:click="hideEditVariantModal"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:admin.product-variant.edit-product-variant :product_variant_id="$productVariantId" />
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
