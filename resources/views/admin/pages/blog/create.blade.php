<div class="container-main">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="header-section">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center">
                <h2>Create Blog</h2>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container-fluid px-4">
            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-6">
                    <div class="form-section preview-section">
                        <div class="mb-4">
                            <label class="form-label">Blog Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="templateTitle" placeholder="e.g., News Today" wire:model="title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="mb-3 mt-3 flex-grow-1">
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
                            <button class="btn btn-primary-custom" wire:click="showCategoryModal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    style="vertical-align: middle; margin-right: 4px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tag
                            </button>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Blog Content</label>
                            <livewire:admin.components.text-editor :content="$content" />
                        </div>
                        {{-- #save is used in ckeditor by js --}}

                        <button id="save" class="btn btn-primary-custom">Save</button>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="col-lg-6">
                    <div class="preview-section" style="top: 20px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="preview-title mb-0 section-title">Preview</h2>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary active" id="desktopView">
                                    <i class="bi bi-laptop"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="mobileView">
                                    <i class="bi bi-phone"></i>
                                </button>
                            </div>
                        </div>

                        <div class="email-preview" id="emailPreviewContainer">
                            <!-- Email Header -->
                            <div class="email-header">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-envelope-fill text-primary me-2"></i>
                                    <small class="text-white">noreply@yourcompany.com</small>
                                </div>
                                <div class="email-subject">
                                    <div class="subject-label">SUBJECT</div>
                                    <div class="subject-text" id="previewTitle">
                                        {{ $title ?: 'Your email title' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Email Body -->
                            <div class="email-body">
                                <div class="email-content" id="previewContent">
                                    @if ($content)
                                        {!! $content !!}
                                    @else
                                        <p class="text-muted">Your email content will appear here...</p>
                                    @endif
                                </div>

                                <!-- Email Footer -->
                                {{-- <div class="email-footer">
                                    <div class="footer-content">
                                        <p class="mb-2">© 2025 Your Company. All rights reserved.</p>
                                        <p class="mb-0 text-muted small">
                                            <i class="bi bi-geo-alt"></i> 123 Main Street, City, Country
                                        </p>
                                        <div class="mt-2">
                                            <a href="#" class="footer-link">Unsubscribe</a> |
                                            <a href="#" class="footer-link">Privacy Policy</a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @if ($openImageModal)
                <div class="modal fade show d-block" tabindex="-1" role="dialog" wire:click.self="hideImageModal"
                    style="background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title  text-white">Add Image to Blog</h5>
                                <button type="button" class="btn-close" wire:click="hideImageModal"></button>
                            </div>
                            <div class="modal-body">
                                <livewire:Admin.Images :currentPage="true" wire:key="images-modal" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($openCategoryModal)
                <div class="modal fade show d-block" tabindex="-1" role="dialog" wire:click.self="hideCategoryModal"
                    style="background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-dialog-centered modal" role="document">
                        <div class="modal-content rounded">
                            <div class="modal-header card-header">
                                <div class="card-header text-white">
                                    <h5 class="mb-0">Select Categories</h5>
                                </div>
                                <button type="button" class="btn-close" wire:click="hideCategoryModal"></button>

                            </div>
                            <div class="modal-body card">
                                <div class="card-body">
                                    <div class="checkbox-container">
                                        {{-- @dd($this->categories) --}}
                                        @forelse ($this->categories as $category)
                                            <div class="checkbox-item mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="category-{{ $category->id }}" value="{{ $category->id }}"
                                                        wire:model.live="selectedCategories">
                                                    <label class="form-check-label"
                                                        for="category-{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <p>Have not any category be used</p>
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
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live preview update for title
            const titleInput = document.getElementById('templateTitle');
            const previewTitle = document.getElementById('previewTitle');

            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    previewTitle.textContent = this.value || 'Your email title';
                });
            }

            // Desktop/Mobile view toggle
            const desktopBtn = document.getElementById('desktopView');
            const mobileBtn = document.getElementById('mobileView');
            const previewContainer = document.getElementById('emailPreviewContainer');

            if (desktopBtn && mobileBtn) {
                desktopBtn.addEventListener('click', function() {
                    previewContainer.classList.remove('mobile-view');
                    desktopBtn.classList.add('active');
                    mobileBtn.classList.remove('active');
                });

                mobileBtn.addEventListener('click', function() {
                    previewContainer.classList.add('mobile-view');
                    mobileBtn.classList.add('active');
                    desktopBtn.classList.remove('active');
                });
            }

            // Livewire event listener for content updates
            if (typeof Livewire !== 'undefined') {
                Livewire.on('contentUpdated', function(content) {
                    document.getElementById('previewContent').innerHTML = content ||
                        '<p class="text-muted">Your email content will appear here...</p>';
                });
            }
        });
    </script>
