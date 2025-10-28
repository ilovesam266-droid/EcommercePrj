<div>
    <div class="container">
        <div class="container-main">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="display-5">📦 Add Product</h1>
                <p class="text-muted">Create and manage products and their variants</p>
            </div>
            <button class="btn btn-secondary" wire:click="showCategoryModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Category
            </button>
            <div class="mb-3 mt-3">
                <div class="rounded p-3 bg-light" style="min-height: 60px;">
                    <div class="d-flex flex-wrap gap-2">
                        @forelse ($categories as $category)
                            <span class="badge bg-primary me-1">
                                {{ $category }}
                            </span>
                        @empty
                            @if ($errors->has('selectedCategories'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('selectedCategories') }}
                                </div>
                            @endif
                        @endforelse
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" wire:click="showImageModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Images
            </button>
            <div class="mb-3 mt-3">
                <div class="rounded bg-light" style="min-height: 60px;">
                    <div class="flex-wrap gap-2">
                        <div class="image-grid" id="grid-all" wire:sc-sortable="images"
                            wire:sc-model.live.debounce.1000ms="image_ids" wire:key="images-{{ count($image_ids) }}"
                            wire:ignore.self>
                            @forelse ($images as $image)
                                <div wire:key="image-{{ $image->id }}" wire:ignore.self sc-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Product 1"
                                        class="img-thumbnail">
                                </div>
                            @empty
                                @if ($errors->has('image_ids'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('image_ids') }}
                                    </div>
                                @endif
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Product Info -->
            <div class="form-section">
                <h3 class="section-title">Product Info</h3>
                <div class="mb-3 mt-3">
                    <div class="rounded bg-light" style="min-height: 60px;">
                        <div class="flex-wrap gap-2">
                            <form id="productForm" wire:submit.prevent="createProduct" novalidate>
                                <div class="col">
                                    <div class="row-md-6 mb-3">
                                        <label for="productName" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="productName" placeholder="Enter product name" wire:model="name"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row-md-6 mb-3">
                                        <label for="productSKU" class="form-label">SKU</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" placeholder="Enter SKU code" wire:model="slug">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">
                                            Status
                                        </label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            wire:model="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="pending">Pending</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                        placeholder="Enter description" wire:model="description" required></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="alert alert-info" role="alert">
                                    <strong>💡 Note:</strong> Please fill full form product before add variant
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="margin-left: 10px; margin-bottom: 10px;"
                                    id="saveBtn">
                                    💾 Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng Biến Thể -->
            <livewire:admin.product-variants :product_id="$productId" />
        </div>
    </div>
    @if ($openImageModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm ảnh</h5>
                        <button type="button" class="btn-close" wire:click="hideImageModal"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:Admin.Images :currentPage="true" wire:key="images-modal" />
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Chọn categories --}}
    @if ($openCategoryModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header card-header bg-primary text-white">
                        <div class="card-header">
                            <h5 class="mb-0">Chọn Lựa Chọn</h5>
                            <button type="button" class="btn-close" wire:click="hideCategoryModal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card shadow-sm" style="max-width: 400px; margin: 0 auto;">
                            <div class="card-body">
                                <div class="checkbox-container">
                                    {{-- @dd($this->categories) --}}
                                    @forelse ($this->categories as $category)
                                        <div class="checkbox-item mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="category-{{ $category->id }}" value="{{ $category->id }}"
                                                    wire:model.live="selectedCategories">
                                                <label class="form-check-label" for="category-{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <p>Chưa có category nào được tải lên.</p>
                                    @endforelse
                                </div>
                                {{-- <button class="btn btn-primary btn-get-values w-100" wire:click="getSelectedValues">
                                    Lấy Giá Trị Đã Chọn
                                </button> --}}

                                <div class="result-text" id="resultText"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@endif
</div>
