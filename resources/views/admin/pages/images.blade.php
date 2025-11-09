<div class="container-fluid py-4">
    <!-- Alert Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <livewire:admin.image.upload-image />
        </div>
        <!-- Main Content Area -->

        <div class="col mb-4">
            {{-- <h2 class="text-2xl font-bold mb-4">Tất cả ảnh</h2> --}}
            <div class="">
            </div>
            <div class="container-lg">
                <div class="container-main">
                    <!-- Header -->
                    <div class="header-section">
                        <h2><i class=""></i> Manage Image</h2>
                    </div>

                    <!-- Tab Buttons -->
                    <ul class="nav nav-tabs mb-4" id="photoManagerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($currentTab === 'all_photos') active @endif" id="all-photos-tab"
                                data-bs-toggle="tab" data-bs-target="#all-photos" type="button" role="tab"
                                aria-controls="all-photos"
                                aria-selected="{{ $currentTab === 'all_photos' ? 'true' : 'false' }}"
                                wire:click="selectTab('all_images')">
                                All images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($currentTab === 'my_photos') active @endif" id="my-photos-tab"
                                data-bs-toggle="tab" data-bs-target="#my-photos" type="button" role="tab"
                                aria-controls="my-photos"
                                aria-selected="{{ $currentTab === 'my_photos' ? 'true' : 'false' }}"
                                wire:click="selectTab('my_images')">
                                My images
                            </button>
                        </li>
                    </ul>
                    {{-- <div class="row">
                        <div class="selected-count" id="selectedCount">
                            <strong id="countText">0 ảnh được chọn</strong>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary" id="selectAllBtn">
                                <i class="bi bi-check-square"></i> Chọn Tất Cả
                            </button>
                            <button class="btn btn-secondary" id="deselectAllBtn">
                                <i class="bi bi-square"></i> Bỏ Chọn Tất Cả
                            </button>
                        </div>
                    </div> --}}
                    <!-- Tab 2: My Images -->
                    <div id="my-images" class="tab-content active">
                        <div class="image-grid" id="grid-all">
                            <!-- Image Card 1 -->
                            @forelse ($this->images as $image)
                                <div wire:key="modal-library-image-{{ $image->id }}"
                                    wire:click="toggleSelection({{ $image->id }})"
                                    class="image-card relative w-full aspect-w-1 aspect-h-1 overflow-hidden rounded-lg border-2 cursor-pointer transition-all
                                        {{ in_array($image->id, $selectedImageId) ? 'selected border-blue-500 ring-2 ring-blue-500' : 'border-gray-200 hover:border-blue-300' }}">
                                    <div class="image-wrapper">
                                        <i class="image-placeholder bi bi-image"></i>
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $image->name }}"
                                            class="w-full h-48 object-cover">
                                    </div>
                                    <div class="image-info">
                                        <div class="image-name">{{ $image->name }}</div>
                                        <div class="image-meta">Sản Phẩm •
                                            {{ $image->created_at->diffForHumans() }}</div>
                                        <div class="image-actions">
                                            <button class="action-btn view" title="Xem"
                                                wire:click="showImage('{{ $image->url }}')">
                                                <i class="bi bi-eye"></i> Xem
                                            </button>
                                            <button class="action-btn delete"
                                                wire:click="confirmDelete({{ $image->id }})"
                                                title="Xóa">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Chưa có ảnh nào được tải lên.</p>
                            @endforelse
                        </div>
                        @if ($currentPage)
                            <button wire:click='uploadImage(@json($selectedImageId))'
                                class="btn btn-primary-custom">Select</button>
                        @endif
                    </div>
                </div>
                @if ($showedImage)
                    <div class="modal fade show d-block" tabindex="-1" role="dialog"
                        style="background-color: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" wire:click="hideImage"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="image-wrapper">
                                        <i class="image-placeholder bi bi-image"></i>
                                        <img src="{{ asset('storage/' . $selectedImage) }}" class="w-100 object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="mt-4">
                {{ $this->images->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
