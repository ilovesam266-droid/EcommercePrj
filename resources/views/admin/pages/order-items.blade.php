<div class="variant-table">
    <div class="table-responsive rounded-3 border-3 text-center align-middle">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="font-weight: 500;">Id</th>
                    <th style="font-weight: 500;">Tên Sản Phẩm</th>
                    <th style="font-weight: 500;">Số Lượng</th>
                    <th style="font-weight: 500;">Giá Đơn Vị</th>
                    <th style="font-weight: 500;">Tổng Cộng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->order_items as $order_item)
                    <tr class="align-middle">
                        <td>
                            {{ $order_item->id }}
                        </td>
                        <td>
                            <strong><span
                                    class="variant">{{ $order_item->productVariantSize->full_name }}</span></strong>
                        </td>
                        <td>
                            <small>
                                {{ $order_item->quantity }}
                            </small>
                        </td>
                        <td>
                            <small>{{ number_format($order_item->productVariantSize->price, 0, ',', '.') }} ₫</small>
                        </td>

                        <td>
                            <small
                                style="color: primary; font-weight: 600;">
                                {{ number_format($order_item->total_price, 0, ',', '.') }} ₫
                            </small>
                        </td>

                        {{-- <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-warning btn-action"
                                    wire:click="showEditVariantModal({{ $order_item->id }})">
                                    <i class="bi bi-pencil">
                                        <svg class="nav-icon" style="width: 20px;height: 20px;">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                                        </svg>
                                    </i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-action"
                                    wire:click="deleteVariant({{ $order_item->id }})"
                                    wire:confirm="Are you sure you want to delete this user?">
                                    <i class="bi bi-pencil">
                                        <svg class="nav-icon" style="width: 20px;height: 20px;">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                                        </svg>
                                    </i>
                                </button>
                            </div>
                        </td> --}}
                    </tr>
                {{-- @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 60px 20px;">
                            <div class="empty-state">
                                <div class="empty-state-icon" style="font-size: 48px; margin-bottom: 16px;">📋</div>
                                <p style="color: #718096; font-size: 16px; margin: 0;">Chưa có biến thể nào. Hãy thêm
                                    biến thể đầu tiên!</p>
                            </div>
                        </td>
                    </tr> --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>
