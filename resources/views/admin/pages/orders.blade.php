<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
<div class="card shadow-sm rounded mb-4">
            <livewire:admin.components.search-filter :filterConfigs="$orderFiltersConfig" placeholderSearch="Search by name" />
        </div>
    <!-- Orders Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-box-seam"></i> Order List
                </h3>
                <a class="btn btn-primary" href="{{ route('admin.create_order') }}">
                    <i class="bi bi-plus-circle"></i> Add Order
                </a>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>Order</th>
                                <th>User</th>
                                <th>Address</th>
                                <th>Total Price</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->orders as $order)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">#ORD-{{ $order->id }}</div>
                                    </td>
                                    <td>
                                                {{-- <div class="d-flex align-items-center py-1">
                                                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-2"
                                                        style="width: 28px; height: 28px; min-width: 28px;">
                                                        <i class="bi bi-geo-alt-fill text-danger"
                                                            style="font-size: 11px;"></i>
                                                    </div>
                                                    <span
                                                        class="text-muted">{{ $order->owner->address ?? 'Chưa cập nhật' }}</span>
                                                </div> --}}
                                        <div class="text-nowrap">{{ $order->owner->full_name }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $order->owner->username }}</span>
                                        </div>
                                        <div class="small text-body-secondary text-nowrap">{{ $order->owner->email }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $order->province }}</div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>{{ $order->district }}{{ $order->ward }}</span>
                                        </div>
                                    </td>
                                    <td><strong>{{ $order->formatted_total }}</strong></td>
                                    <td><span
                                            class="status-badge {{ $order->status->colorClass() }}">{{ $order->status }}</span>
                                    </td>
                                    <td><span
                                            class="payment-badge {{ $order->payment->payment_method->colorClass() }}">{{ $order->payment->payment_method }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                        <small
                                            style="color: #718096;">{{ $order->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-primary btn-action" title="Details Order"
                                                wire:click="openDetailsModal({{ $order->id }})">
                                                <svg class="nav-icon"
                                                    style="width: 20px;height: 20px;  stroke: currentColor; fill: currentColor;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-airplay">
                                                    </use>
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-action" title="Delete" wire:click="deleteOrder({{ $order->id }})"
                                                wire:confirm="Are you sure you want to delete this order">
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
    </div>
    @if ($showDetailsModal && $detailsOrderId)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light border-0 pb-0">
                        <div>
                            <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Mã đơn:
                                <strong>#ORD-{{ $detailsOrderId }}</strong>
                            </p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="closeDetailsModal"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:admin.order.details-order :order-id="$detailsOrderId" />
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->orders->onEachSide(1)->links() }}
    </div>
</div>
