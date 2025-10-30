<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive text-center align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-secondary">
                    <i class="bi bi-box-seam"></i> Order Management
                </h4>
                <a class="btn btn-primary" href="{{ route('admin.create_order') }}">
                    <i class="bi bi-plus-circle"></i> Add Order
                </a>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Email</th>
                                <th>Total Price</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->orders as $order)
                                <tr class="align-middle">
                                    <td><strong>#ORD-{{ $order->id }}</strong></td>
                                    <td>{{ $order->owner->email }}</td>
                                    <td><strong>{{ $order->formatted_total }}</strong></td>
                                    <td><span class="status-badge status-delivered">{{ $order->status }}</span></td>
                                    <td><span
                                            class="payment-badge payment-completed">{{ $order->payment_status_label }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $order->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-primary btn-action" title="Xem chi tiết"
                                                data-bs-toggle="modal" data-bs-target="#viewOrderModal"
                                                wire:click="openDetailsModal({{ $order->id }})">
                                                <svg class="nav-icon"
                                                    style="width: 20px;height: 20px;  stroke: currentColor; fill: currentColor;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-airplay">
                                                    </use>
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" title="Xóa">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($showDetailsModal && $detailsOrderId)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light border-0 pb-0">
                            <div>
                                <h4 class="mb-0 text-secondary">
                                    <i class="bi bi-box-seam"></i> Order Details
                                </h4>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Mã đơn:
                                    <strong>#ORD-{{ $detailsOrderId }}</strong>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                wire:click="closeDetailsModal"></button>
                        </div>
                        <div class="modal-body">
                            <livewire:admin.order.details-order :order-id="$detailsOrderId" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->orders->onEachSide(1)->links() }}
    </div>
</div>
