<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm rounded mb-4">
        <livewire:admin.components.search-filter :filterConfigs="$reviewFiltersConfig" placeholderSearch="Search by user or product" />
    </div>
    <!-- Reviews Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive align-middle">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-star-fill"></i> Review List
                </h3>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->reviews as $review)
                                <tr class="align-middle">
                                    {{-- <td>
                                        <div class="text-nowrap">#{{ $review->id }}</div>
                                    </td> --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $review->user->first_name }}
                                                {{ $review->user->last_name }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>{{ $review->user->username }}</span>
                                                <span class="copy-icon"
                                                    onclick="copyToClipboard('{{ $review->user->username }}')"
                                                    title="Copy review">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                        <path
                                                            d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="small text-body-secondary text-nowrap">
                                                {{ $review->user->email }}
                                            </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{ $review->product->name }}<span class="copy-icon"
                                                    onclick="copyToClipboard('{{ $review->product->name }}')"
                                                    title="Copy review">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M10 1.5v1H4a1 1 0 0 0-1 1v8H2V3a2 2 0 0 1 2-2h6z" />
                                                        <path
                                                            d="M5 5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm1 0v9h6V5H6z" />
                                                    </svg>
                                                </span></div>
                                        <div class="small text-body-secondary text-nowrap">
                                            <span>SKU: {{ $review->product->slug ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star-fill {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"
                                                    style="font-size: 14px;"></i>
                                            @endfor
                                            <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ Str::limit($review->body, 20) ?? 'No comment' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $review->status->colorClass() }}">
                                            {{ $review->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $review->created_at->format('d/m/Y') }}</div>
                                        <small
                                            style="color: #718096;">{{ $review->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($review->status !== 'approved')
                                                <button class="btn btn-sm btn-success btn-action" title="Approve"
                                                    wire:click="approveReview({{ $review->id }})">
                                                    <svg class="icon">
                                                        <use
                                                            xlink:href="vendors/@coreui/icons/svg/free.svg#cil-thumb-up">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                            @if ($review->status !== 'rejected')
                                                <button class="btn btn-sm btn-warning btn-action" title="Reject"
                                                    wire:click="rejectReview({{ $review->id }})">
                                                    <svg class="icon">
                                                        <use
                                                            xlink:href="vendors/@coreui/icons/svg/free.svg#cil-thumb-down">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger btn-action" title="Delete"
                                                wire:click="confirmDelete({{ $review->id }})">
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
    {{-- @if ($showDetailsModal && $detailsReviewId)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light border-0 pb-0">
                        <div>
                            <h5 class="modal-title" id="reviewModalLabel">Review Details</h5>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Review ID:
                                <strong>#{{ $detailsReviewId }}</strong>
                            </p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="closeDetailsModal"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:admin.review.details-review :review-id="$detailsReviewId" />
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
    <livewire:admin.components.modal-confirm />
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->reviews->onEachSide(1)->links() }}
    </div>
</div>
