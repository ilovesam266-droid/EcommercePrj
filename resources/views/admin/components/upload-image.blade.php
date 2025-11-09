<div>
    <style>
        /* CSS cho phần này, bạn có thể chuyển nó vào file CSS riêng */
        .upload-container {
            max-width: 600px;
            margin: 0px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border: 1px solid #e0e0e0;
        }

        .upload-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .upload-header h2 {
            font-size: 2.2em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .upload-header p {
            font-size: 1.1em;
            color: #666;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.95em;
        }

        .alert-info {
            background-color: #e0f7fa;
            color: #007bff;
            border: 1px solid #b2ebf2;
        }

        .alert-info small {
            font-weight: 500;
        }

        /* Type Selector */
        .type-selector {
            margin-bottom: 30px;
        }

        .type-selector label {
            display: block;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1.1em;
            color: #333;
        }

        .btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .type-btn {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #ced4da;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }

        .type-btn:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .btn-check:checked+.type-btn {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #007bff;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            background-color: #f0f8ff;
            width: 100%;
        }

        .upload-area.drag-leave {
            border-color: #0056b3;
        }

        .upload-area.drag-over {
            background-color: #e6f7ff;
            border-color: #0056b3;
            border-style: solid;
        }

        .upload-icon {
            font-size: 3.5em;
            color: #007bff;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 1.3em;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .upload-subtext {
            font-size: 0.9em;
            color: #666;
        }

        .file-input {
            display: none;
            /* Ẩn input file mặc định */
        }

        /* File Preview */
        .file-preview {
            margin-top: 25px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            gap: 20px;
            display: none;
            /* Ban đầu ẩn đi */
        }

        .file-preview.active {
            display: flex;
            /* Hiện khi có ảnh */
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .preview-info {
            font-size: 0.95em;
            color: #555;
        }

        .preview-info strong {
            color: #333;
        }

        /* Submit Button */
        .btn-submit {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 30px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: #218838;
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-submit:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        /* Error message */
        .error {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }
    </style>

    <div class="upload-container">
        <!-- Header -->
        <div class="upload-header">
            <h2>📤 Upload Image</h2>
            <p>Chọn loại nội dung và tải lên hình ảnh của bạn</p>
        </div>

        <!-- Alert Info -->
        <div class="alert alert-info" role="alert">
            <small>✓ Hỗ trợ: JPG, PNG, GIF (Tối đa 5MB mỗi ảnh)</small>
        </div>

        {{-- Session messages --}}
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        {{-- Hiển thị lỗi cho toàn bộ mảng images --}}
        @error('images')
            <span class="error">{{ $message }}</span>
        @enderror
        {{-- Hiển thị lỗi cho từng file trong mảng images --}}
        @error('images.*')
            <span class="error">{{ $message }}</span>
        @enderror


        <!-- Form -->
        <form wire:submit.prevent="uploadImages" id="uploadForm">
            <!-- type Selector -->
            <div class="type-selector">
                <label for="type">Chọn Loại Nội Dung</label>
                <div class="btn-group-vertical" role="group">
                    <input type="radio" class="btn-check" name="type" id="products" value="products" wire:model="type" {{ $type === 'products' ? 'checked' : '' }}>
                    <label class= "btn type-btn {{ $type === 'products' ? 'active' : '' }}" for="products">
                        🛍️ Sản Phẩm (Product)
                    </label>

                    <input type="radio" class="btn-check" name="type" id="blogs" value="blogs" wire:model="type" {{ $type === 'blogs' ? 'checked' : '' }}>
                    <label class="btn type-btn {{ $type === 'blogs' ? 'active' : '' }}" for="blogs">
                        📝 Bài Viết (Blog)
                    </label>
                </div>
            </div>
            <!-- Upload Area -->
            <label class="upload-area" id="uploadArea" for="fileInput">
                <div class="upload-icon">📁</div>
                <div class="upload-text">Kéo thả hình ảnh vào đây</div>
                <div class="upload-subtext">hoặc nhấp để chọn từ máy tính</div>
            </label>
            <!-- File Input -->
            <input type="file" id="fileInput" class="file-input" accept="image/*" wire:model.change="images"
                multiple>

            <!-- File Preview -->
            <div class="file-preview {{ !empty($images) ? 'active' : '' }}" id="filePreview">
                @if (!empty($images))
                    @foreach ($images as $index => $image)
                        <div class="preview-item">
                            <img src="{{ $image->temporaryUrl() }}" class="preview-image" alt="Preview">
                            <button type="button" class="remove-btn"
                                wire:click="removeImage({{ $index }})">&times;</button>
                            {{-- Bạn có thể thêm tên và kích thước file ở đây nếu muốn --}}
                            {{-- <div class="preview-info">
                                <strong>{{ $image->getClientOriginalName() }}</strong><br>
                                <span>{{ number_format($image->getSize() / 1024, 2) }} KB</span>
                            </div> --}}
                        </div>
                    @endforeach
                @else
                    {{-- Placeholder hoặc nội dung rỗng nếu không có ảnh --}}
                @endif
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn" {{ !empty($images) ? '' : 'disabled' }}>
                Tải Lên
            </button>
        </form>

        {{-- Hiển thị ảnh đã tải lên (nếu có) --}}
        @if (!empty($url))
            <div class="mt-4 text-center">
                <h3>Các Ảnh Đã Tải Lên:</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                    @foreach ($url as $imageUrl)
                        <img src="{{ $imageUrl }}" alt="Uploaded Image"
                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@script
    <script>
        window.cleanupDragAndDrop = new Function();

        window.setupDragAndDrop = function() {
            const dropZoneElement = document.getElementById('uploadArea');
            const updateStateDropZone = function(event, isDragOver) {
                event.preventDefault();

                dropZoneElement.classList.toggle("drag-over", typeof isDragOver !== 'undefined' && isDragOver);
                dropZoneElement.classList.toggle("drag-leave", typeof isDragOver !== 'undefined' && !isDragOver);
            }

            const handleListener = {
                dragover: (e) => updateStateDropZone(e, true),
                dragleave: (e) => updateStateDropZone(e, false),
                drop: (e) => {
                    updateStateDropZone(e);

                    $wire && $wire.uploadMultiple('images', e.dataTransfer.files, new Function(), $wire
                        .showUploadError);
                }
            };

            Object.entries(handleListener).forEach(([eventName, handler]) => {
                dropZoneElement.addEventListener(eventName, handler);
            });

            window.cleanupDragAndDrop = function() {
                Object.entries(handleListener).forEach(([eventName, handler]) => {
                    dropZoneElement.removeEventListener(eventName, handler);
                });
            }
        }

        setupDragAndDrop();

        function handleImagePickerCleanup(element, shouldReset = false) {
            if (element && element.classList.contains('image-picker-modal')) {
                cleanupDragAndDrop();

                shouldReset && setupDragAndDrop();
            }
        }

        Livewire.hook('morph.removing', ({
            element
        }) => handleImagePickerCleanup(element));
        Livewire.hook('morph.updated', ({
            element
        }) => handleImagePickerCleanup(element, true));
    </script>
@endscript
