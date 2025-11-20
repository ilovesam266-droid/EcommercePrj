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
                                    class="variant">{{ $order_item->productVariantSize->full_name ?? 'N/A' }}</span></strong>
                        </td>
                        <td>
                            <small>
                                {{ $order_item->quantity }}
                            </small>
                        </td>
                        <td>
                            <small>{{ number_format($order_item->productVariantSize?->price ?? 0, 0, ',', '.') }}
                                ₫</small>
                        </td>

                        <td>
                            <small style="color: primary; font-weight: 600;">
                                {{ number_format($order_item->total_price, 0, ',', '.') }} ₫
                            </small>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
