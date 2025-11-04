<div class="container-main">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="header-section">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center">
                <h2>Create Template</h2>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container-fluid px-4">
            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-6">
                    <div class="form-section preview-section">
                        <div class="d-flex align-items-center gap-3">
                            <div class="mb-4 flex-grow-1">
                            <label for="emailName" class="form-label">Email Name</label>
                            <input type="text" id="emailName" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter email name" wire:model="name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4 flex-grow-1">
                            <label for="type" class="form-label">Email Type</label>
                            <select id="type" class="form-control @error('type') is-invalid @enderror"
                                wire:model="type">
                                <option value="">-- Select email type --</option>
                                @foreach (\App\Enums\MailType::cases() as $case)
                                    <option value="{{ $case->value }}">{{ $case->label() }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Template Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="templateTitle" placeholder="e.g., Welcome Email" wire:model="title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email Content</label>
                            {{-- <textarea class="form-control" id="emailContent" placeholder="Write your email content here..."></textarea> --}}
                            <livewire:admin.components.text-editor />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Variables</label>
                            @foreach ($variables as $key => $value)
                                <div class="d-flex mb-2">
                                    <input type="text" class="form-control me-2"
                                        wire:model.defer="variables.{{ $key }}"
                                        placeholder="{{ $key }}">
                                    <button type="button" wire:click="removeVariable('{{ $key }}')"
                                        class="btn btn-danger btn-sm">X</button>
                                </div>
                            @endforeach

                            <div class="d-flex">
                                <input type="text" class="form-control me-2" wire:model.defer="newVariableKey"
                                    placeholder="Key">
                                <input type="text" class="form-control me-2" wire:model.defer="newVariableValue"
                                    placeholder="Value">
                                <button type="button" wire:click="addVariable"
                                    class="btn btn-primary btn-sm">Add</button>
                            </div>

                            @error('variables')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Scheduled At</label>
                            <input type="datetime-local" id="scheduledAt"
                                class="form-control @error('scheduled_at') is-invalid @enderror"
                                wire:model="scheduled_at">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button id="save" class="btn btn-primary">Lưu Nội Dung</button>
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
                                    <small class="text-muted">noreply@yourcompany.com</small>
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
                                    @if ($body)
                                        {!! $body !!}
                                    @else
                                        <p class="text-muted">Your email content will appear here...</p>
                                    @endif
                                </div>

                                <!-- Variables Preview -->
                                @if (count($variables) > 0)
                                    <div class="variables-preview mt-4">
                                        <div class="variables-label">
                                            <i class="bi bi-code-slash"></i> Template Variables
                                        </div>
                                        <div class="variables-list">
                                            @foreach ($variables as $key => $value)
                                                <div class="variable-item">
                                                    <code class="variable-key">{{ '{' . $key . '}' }}</code>
                                                    <span class="variable-arrow">→</span>
                                                    <span class="variable-value">{{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Email Footer -->
                                <div class="email-footer">
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
                                </div>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div class="preview-info mt-3">
                            <div class="d-flex justify-content-between text-muted small">
                                <span>
                                    <i class="bi bi-clock"></i>
                                    @if ($scheduled_at)
                                        Scheduled: {{ date('M d, Y H:i', strtotime($scheduled_at)) }}
                                    @else
                                        Not scheduled
                                    @endif
                                </span>
                                <span>
                                    <i class="bi bi-tag"></i> {{ $type ?: 'No type' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
