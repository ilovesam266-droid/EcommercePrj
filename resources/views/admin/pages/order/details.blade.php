<div>
    <!-- Order Status Timeline -->
    <div class="mb-4 pb-4 border-bottom">
        <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">Trạng Thái Đơn Hàng</h6>
        <div class="d-flex justify-content-between align-items-center">
            @php
                // Xác định trạng thái của từng bước dựa trên status
                $isPending = true; // Step 1 luôn được hoàn thành khi đơn hàng được tạo

                // Step 2: Confirmed hoặc Canceled
                $isConfirmed = in_array($status->value, ['confirmed', 'shipping', 'done', 'failed']);
                $isCanceled = $status->value === 'canceled';

                // Step 3: Shipping
                $isShipping = in_array($status->value, ['shipping', 'done', 'failed']);

                // Step 4: Delivered hoặc Failed
                $isDone = $status->value === 'done';
                $isFailed = $status->value === 'failed';

                // Màu sắc
                $greenBg = '#dcfce7';
                $greenBorder = '#10b981';
                $greenColor = '#10b981';

                $grayBg = '#f3f4f6';
                $grayBorder = '#d1d5db';
                $grayColor = '#9ca3af';

                $redBg = '#fee2e2';
                $redBorder = '#ef4444';
                $redColor = '#ef4444';
            @endphp
            {{-- @dump($status) --}}
            <!-- Step 1: Pending -->
            <div class="text-center flex-grow-1">
                <div class="mb-2">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%;
            background-color: {{ $greenBg }};
            border: 2px solid {{ $greenBorder }};
            margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-lg" style="color: {{ $greenColor }}; font-size: 1.25rem;"></i>
                    </div>
                </div>
                <p class="mb-1" style="font-size: 0.875rem; font-weight: 500;">Chờ Xác Nhận</p>
                <p class="text-muted" style="font-size: 0.75rem;">{{ $created_at->format('d/m/Y') }}</p>
            </div>
            <div
                style="flex-grow: 0.5; height: 2px;
    background-color: {{ $isConfirmed || $isCanceled ? ($isCanceled ? $redBorder : $greenBorder) : $grayBorder }};
    margin: 0 -8px;">
            </div>

            <!-- Step 2: Confirmed/Canceled -->
            <div class="text-center flex-grow-1">
                <div class="mb-2">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%;
            background-color: {{ $isCanceled ? $redBg : ($isConfirmed ? $greenBg : $grayBg) }};
            border: 2px solid {{ $isCanceled ? $redBorder : ($isConfirmed ? $greenBorder : $grayBorder) }};
            margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        @if ($isCanceled || $isConfirmed)
                            <i class="bi bi-check-lg"
                                style="color: {{ $isCanceled ? $redColor : $greenColor }}; font-size: 1.25rem;"></i>
                        @endif
                    </div>
                </div>
                <p class="mb-1" style="font-size: 0.875rem; font-weight: 500;">
                    {{ $isCanceled ? 'Đã Hủy' : 'Đã Xác Nhận' }}
                </p>
                @if ($isConfirmed || $isCanceled)
                    <p class="text-muted" style="font-size: 0.75rem;">
                        {{ $confirmed_at?->format('d/m/Y') ?? $updated_at->format('d/m/Y') }}</p>
                @else
                    <p class="text-muted" style="font-size: 0.75rem;">--</p>
                @endif
            </div>
            <div
                style="flex-grow: 0.5; height: 2px;
    background-color: {{ $isShipping && !$isCanceled ? $greenBorder : $grayBorder }};
    margin: 0 -8px;">
            </div>

            <!-- Step 3: Shipped -->
            <div class="text-center flex-grow-1">
                <div class="mb-2">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%;
            background-color: {{ $isShipping && !$isCanceled ? $greenBg : $grayBg }};
            border: 2px solid {{ $isShipping && !$isCanceled ? $greenBorder : $grayBorder }};
            margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        @if ($isShipping && !$isCanceled)
                            <i class="bi bi-check-lg" style="color: {{ $greenColor }}; font-size: 1.25rem;"></i>
                        @endif
                    </div>
                </div>
                <p class="mb-1" style="font-size: 0.875rem; font-weight: 500;">Đang Giao</p>
                @if ($isShipping && !$isCanceled)
                    <p class="text-muted" style="font-size: 0.75rem;">
                        {{ $shipping_at?->format('d/m/Y') ?? '--' }}</p>
                @else
                    <p class="text-muted" style="font-size: 0.75rem;">--</p>
                @endif
            </div>
            <div
                style="flex-grow: 0.5; height: 2px;
    background-color: {{ $isDone || $isFailed ? ($isFailed ? $redBorder : $greenBorder) : $grayBorder }};
    margin: 0 -8px;">
            </div>

            <!-- Step 4: Done/Failed -->
            <div class="text-center flex-grow-1">
                <div class="mb-2">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%;
            background-color: {{ $isFailed ? $redBg : ($isDone ? $greenBg : $grayBg) }};
            border: 2px solid {{ $isFailed ? $redBorder : ($isDone ? $greenBorder : $grayBorder) }};
            margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        @if ($isDone || $isFailed)
                            <i class="bi bi-check-lg"
                                style="color: {{ $isFailed ? $redColor : $greenColor }}; font-size: 1.25rem;"></i>
                        @endif
                    </div>
                </div>
                <p class="mb-1" style="font-size: 0.875rem; font-weight: 500;">
                    {{ $isFailed ? 'Thất Bại' : 'Đã Giao' }}
                </p>
                @if ($isDone || $isFailed)
                    <p class="text-muted" style="font-size: 0.75rem;">
                        {{ $done_at?->format('d/m/Y') ?? $updated_at->format('d/m/Y') }}</p>
                @else
                    <p class="text-muted" style="font-size: 0.75rem;">--</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Customer Information Card -->
    <div class="mb-4">
        <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">Thông
            Tin
            Khách Hàng</h6>
        <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #2563eb;">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Tên Khách Hàng</p>
                    <p class="mb-0" style="font-weight: 500;">{{ $recipient_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Số Điện Thoại</p>
                    <p class="mb-0" style="font-weight: 500;">{{ $recipient_phone }}</p>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Địa Chỉ Giao Hàng</p>
                    <p class="mb-0" style="font-weight: 500;">{{ $full_address }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Information Card -->
    <div class="mb-4">
        <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">Thông
            Tin
            Thanh Toán</h6>
        <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.5rem;">
            <div class="row mb-3">
                <div class="col-6">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Phương Thức</p>
                    <p class="mb-0" style="font-weight: 500;">{{ $payment_method_label }}</p>
                </div>
                <div class="col-6">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Trạng Thái</p>
                    <p class="mb-0"><span class="payment-badge payment-completed">{{ $payment_status_label }}</span>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Mã Giao Dịch</p>
                    <p class="mb-0" style="font-weight: 500; font-family: monospace; font-size: 0.875rem;">
                        {{ $payment_transaction_code }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Summary Card -->
    <div class="mb-4">
        <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">Chi
            Tiết
            Thanh Toán</h6>
    <livewire:admin.order-items :order_id="$orderId">

        <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.5rem;">
            <div class="row mb-2">
                <div class="col-6">
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Tổng Tiền Hàng</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-0" style="font-weight: 500;">{{ $formatted_price }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Phí Vận Chuyển</p>
                </div>
                <div class="col-6 text-end">
                    @if ($formatted_shipping_fee)
                        <p class="mb-0" style="font-weight: 500;">{{ $formatted_shipping_fee }}</p>
                    @else
                        <p class="mb-0" style="font-weight: 500;">0 ₫</p>
                    @endif
                </div>
            </div>
            <div style="border-top: 2px solid #e5e7eb; padding-top: 1rem;">
                <div class="row">
                    <div class="col-6">
                        <p class="mb-0" style="font-weight: 600; font-size: 1rem;">Tổng Cộng</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-0" style="font-weight: 700; font-size: 1.125rem; color: #2563eb;">
                            {{ $formatted_total }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div>
        <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">Ghi Chú
        </h6>
        <div style="background-color: #fef3c7; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
            <p class="mb-0" style="font-size: 0.875rem;">
                <i class="bi bi-info-circle" style="color: #92400e; margin-right: 0.5rem;"></i>
                <span style="color: #92400e;">Giao hàng vào buổi sáng, liên hệ trước khi giao.</span>
            </p>
        </div>
    </div>


    <div class="modal-footer border-top">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Chỉnh Sửa
        </button>
        <button type="button" class="btn btn-outline-danger">
            <i class="bi bi-printer"></i> In Đơn
        </button>
    </div>
</div>
