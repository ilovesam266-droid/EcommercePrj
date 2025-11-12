<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="createCategory">
        <div class="card-body">

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">
                    Name <span class="required">*</span>
                </label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       wire:model="name"
                       placeholder="Category Name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-3">
                <label for="slug" class="form-label">
                    Slug <span class="required">*</span>
                </label>
                <input type="text"
                       class="form-control @error('slug') is-invalid @enderror"
                       id="slug"
                       wire:model="slug"
                       placeholder="category-slug">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Slug must be unique and URL-friendly</div>
            </div>

            <!-- Status -->
            {{-- <div class="mb-3">
                <label for="status" class="form-label">
                    Status <span class="required">*</span>
                </label>
                <select class="form-select @error('status') is-invalid @enderror"
                        id="status"
                        wire:model="status"
                        required>
                    <option value="active">Active</option>
                    <option value="inactive" selected>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Submit Buttons -->
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Add Category
                </button>
                <button type="reset" class="btn btn-secondary">
                    Reset Form
                </button>
            </div>

        </div>
    </form>
</div>
