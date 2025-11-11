<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="editAddress">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Recipient Name <span class="required">*</span></label>
                <input type="text" class="form-control @error('recipient_name') is-invalid @enderror"
                       wire:model="recipient_name" placeholder="Full name of recipient">
                @error('recipient_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Recipient Phone <span class="required">*</span></label>
                <input type="text" class="form-control @error('recipient_phone') is-invalid @enderror"
                       wire:model="recipient_phone" placeholder="Phone number">
                @error('recipient_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" class="form-control @error('province') is-invalid @enderror"
                           wire:model="province">
                    @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">District</label>
                    <input type="text" class="form-control @error('district') is-invalid @enderror"
                           wire:model="district">
                    @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ward</label>
                    <input type="text" class="form-control @error('ward') is-invalid @enderror"
                           wire:model="ward">
                    @error('ward') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Detailed Address</label>
                <textarea class="form-control @error('detailed_address') is-invalid @enderror" rows="2"
                          wire:model="detailed_address" placeholder="Street, house number..."></textarea>
                @error('detailed_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="isDefault" wire:model="is_default">
                <label class="form-check-label" for="isDefault">Set as default address</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         style="display:inline-block;vertical-align:middle;margin-right:8px;">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round"/>
                    </svg>
                    Edit Address
                </button>
            </div>
        </div>
    </form>
</div>
