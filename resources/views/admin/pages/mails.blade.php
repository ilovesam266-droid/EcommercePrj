<div class="p-4 bg-white rounded shadow">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card shadow-sm rounded">
        <div class="table-responsive">
            <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-box-seam"></i> Mail List
                </h3>
                <a class="btn btn-primary-custom" href="{{ route('admin.create_mail') }}">
                    <i class="bi bi-plus-circle"></i>  + Add Mail
                </a>
            </div>
            <div class="p-4">
                <div class="rounded-3 overflow-hidden border">
                    <table class="table table-hover border mb-0">
                        <thead class="table-light align-middle centered-cell">
                            <tr>
                                <th>#</th>
                                <th>Mail</th>
                                <th>Category</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->mails as $mail)
                                <tr class="align-middle">
                                    <td>
                                        <div class="text-nowrap">{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">Title: {{ $mail->title }}</div>
                                        <div class="small text-body-secondary text-nowrap">#MAIL-{{ $mail->id }}
                                        </div>
                                    </td>
                                    <td><span
                                            class="status-badge {{ $mail->type->colorClass() }}">{{ $mail->type }}</span>
                                    </td>
                                    <td>
                                        <p>{{ Str::before($mail->body, '. ') }}...</p>
                                    </td>
                                    <td>
                                        <div>{{ $mail->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #718096;">{{ $mail->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a title="Edit" class="btn btn-sm btn-info btn-action"
                                                href="{{ route('admin.edit_mail', ['editingMailId' => $mail->id]) }}"><svg
                                                    style="width: 20px;height: 20px;  stroke: currentColor; fill: currentColor; ">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-airplay">
                                                    </use>
                                                </svg></a>
                                            {{-- <button class="btn btn-sm btn-danger btn-action" title="Delete">
                                                <svg class="nav-icon" style="width: 20px;height: 20px;">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash">
                                                    </use>
                                                </svg>
                                            </button> --}}
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
    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->mails->onEachSide(1)->links() }}
    </div>
</div>
