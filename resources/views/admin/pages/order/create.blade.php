<div class="container-main">
    <!-- Header -->
    <div class="header mb-3">
        <h1>Create New Order</h1>
        <p>Enter Details to Create New Order</p>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="createOrder">

        <div class="form-card">
            <div class="section-title">Order Info</div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="shipping">Shipping</option>
                        <option value="canceled">Canceled</option>
                        <option value="failed">Failed</option>
                        <option value="done">Done</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select @error('payment_method') is-invalid @enderror"
                        wire:model="payment_method">
                        <option value="">Select Method</option>
                        <option value="0">Cash on Delivery</option>
                        <option value="1">Credit Card</option>
                        <option value="2">E-wallet</option>
                        <option value="3">Bank Transfer</option>
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control @error('total_amount') is-invalid @enderror money-input"
                        placeholder="0" data-target="total_amount">
                    @error('total_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Shipping Fee</label>
                    <input type="text" class="form-control @error('shipping_fee') is-invalid @enderror money-input"
                        placeholder="0" data-target="shipping_fee">
                    @error('shipping_fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Trạng Thái Thanh Toán</label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" wire:model=payment_status>
                        <option value="">Select Payment Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Paid</option>
                        <option value="2">Failed</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mã Giao Dịch Thanh Toán</label>
                <input type="text" class="form-control @error('payment_transaction_code') is-invalid @enderror"
                    placeholder="VD: TXN123456789" wire:model="payment_transaction_code">
                @error('payment_transaction_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 2: Thông tin người nhận -->
        <div class="form-card">
            <div class="section-title">Recipient Info</div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Recipient Name</label>
                    <input type="text" class="form-control @error('recipient_name') is-invalid @enderror"
                        placeholder="Nhập tên đầy đủ" wire:model="recipient_name">
                    @error('recipient_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Recipient Phone</label>
                    <input type="tel" class="form-control @error('recipient_phone') is-invalid @enderror"
                        placeholder="0123456789" wire:model="recipient_phone">
                    @error('recipient_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 3: Địa chỉ giao hàng -->
        <div class="form-card">
            <div class="section-title">Address</div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Province/City</label>
                    <input class="form-control @error('province') is-invalid @enderror" placeholder="Enter Province"
                        wire:model="province">
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Province/City</label>
                    <input class="form-control @error('district') is-invalid @enderror" placeholder="Enter District"
                        wire:model="district">
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Province/City</label>
                    <input class="form-control @error('ward') is-invalid @enderror" placeholder="Enter Ward"
                        wire:model="ward">
                    @error('ward')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Details Address</label>
                <input type="text" class="form-control @error('detailed_address') is-invalid @enderror"
                    placeholder="Ex: 123 Street, " wire:model="detailed_address">
                @error('detailed_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 4: Ghi chú -->
        <div class="form-card">
            <div class="section-title">Notes</div>

            <div class="form-group">
                <label class="form-label">Notes from recipient</label>
                <textarea class="form-control @error('customer_note') is-invalid @enderror" rows="3"
                    placeholder="Import notes from customers..." wire:model="customer_note"></textarea>
                @error('customer_note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Noted from admin</label>
                <textarea class="form-control @error('admin_note') is-invalid @enderror" rows="3"
                    placeholder="Enter internal notes..." wire:model="admin_note"></textarea>
                @error('admin_note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 5: Thời gian -->
        <div class="form-card">
            <div class="section-title">Time</div>

            <div class="grid-3">
                {{-- <div class="form-group">
                    <label class="form-label">Confirmed Atc</label>
                    <input type="datetime-local" class="form-control @error('confirmed_at') is-invalid @enderror"
                        wire:model="confirmed_at">
                        @error('confirmed_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Shipping At</label>
                    <input type="datetime-local" class="form-control @error('shipping_at') is-invalid @enderror"
                        wire:model="shipping_at">
                        @error('shipping_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Done At</label>
                    <input type="datetime-local" class="form-control @error('done_at') is-invalid @enderror"
                        wire:model="done_at">
                        @error('done_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label class="form-label">Confirmed At</label>
                    <input type="datetime-local" class="form-control @error('confirmed_at') is-invalid @enderror"
                        wire:model.change="confirmed_at" @if ($done_at || $failed_at || $canceled_at) disabled @endif>
                    @error('confirmed_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Shipping At --}}
                <div class="form-group">
                    <label class="form-label">Shipping At</label>
                    <input type="datetime-local" class="form-control @error('shipping_at') is-invalid @enderror"
                        wire:model.change="shipping_at" @if (empty($confirmed_at) || $done_at || $failed_at || $canceled_at) disabled @endif>
                    @error('shipping_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Done At --}}
                <div class="form-group">
                    <label class="form-label">Done At</label>
                    <input type="datetime-local" class="form-control @error('done_at') is-invalid @enderror"
                        wire:model="done_at" @if (empty($shipping_at) || $failed_at || $canceled_at) disabled @endif>
                    @error('done_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Failed At --}}
                <div class="form-group">
                    <label class="form-label">Failed At</label>
                    <input type="datetime-local" class="form-control @error('failed_at') is-invalid @enderror"
                        wire:model="failed_at" @if (empty($shipping_at) || $done_at || $canceled_at) disabled @endif>
                    @error('failed_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Canceled At --}}
                <div class="form-group">
                    <label class="form-label">Canceled At</label>
                    <input type="datetime-local" class="form-control @error('canceled_at') is-invalid @enderror"
                        wire:model="canceled_at" @if (empty($confirmed_at) || $done_at || $failed_at) disabled @endif>
                    @error('canceled_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Reason --}}
            @if ($failed_at || $canceled_at)
                <div class="mt-3">
                    <label class="form-label text-danger">Reason</label>
                    <textarea class="form-control @error('reason') is-invalid @enderror" wire:model="reason"
                        placeholder="Nhập lý do hủy hoặc thất bại"></textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
        </div>
        <!-- Summary -->
        <div class="form-card">
            <div class="section-title">Summary</div>
            <div class="summary-box">
                <div class="summary-row">
                    <span>Total Amount:</span>
                    <strong>{{ number_format($total_amount, 0, ',', '.') }} ₫</strong>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <strong>{{ number_format($shipping_fee, 0, ',', '.') }} ₫</strong>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <strong>{{ number_format($this->total, 0, ',', '.') }} ₫</strong>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="button" class="btn-secondary-custom" wire:click="resetForm">Làm Mới</button>
            <button type="submit" class="btn-primary-custom">Tạo Đơn Hàng</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('input', function(e) {
        const el = e.target;
        if (el.classList.contains('money-input')) {
            let raw = el.value.replace(/\D/g, ''); // chỉ giữ số
            el.value = new Intl.NumberFormat('vi-VN').format(raw); // format hiển thị

            const target = el.dataset.target;
            if (target && window.Livewire) {
                // Dòng này vẫn hoạt động trong form create!
                @this.set(target, parseInt(raw) || 0)
            }
        }
    });
</script>
