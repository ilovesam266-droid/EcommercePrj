<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit.prevent="updateUser">
        <div class="card">
            <div class="card-header">
                <h3>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Add new user
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                        wire:model.live="avatar">
                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        @if ($avatar)
                            <p>Preview new avatar:</p>
                            <img src="{{ $avatar->temporaryUrl() }}" class="img-thumbnail"
                                style="max-width: 150px; max-height: 150px;">
                        @elseif ($currentAvatar)
                            <p>Current Avatar:</p>
                            <img src="{{ asset('storage/'.$currentAvatar) }}" class="img-thumbnail"
                                style="max-width: 150px; max-height: 150px;">
                        @else
                            <p>Not Exist Avatar.</p>
                            <img src="https://via.placeholder.com/150" class="img-thumbnail"
                                style="max-width: 150px; max-height: 150px;">
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">
                                First Name <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                id="firstName" wire:model="first_name" placeholder="First Name">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">
                                Last Name <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                id="lastName" wire:model="last_name" placeholder="Last Name">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="userName" class="form-label">
                            User Name <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="userName" wire:model="username" placeholder="username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M3 7L12 13L21 7" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" wire:model="email" placeholder="example@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Email must be unique</div>
                    </div>

                    <div class="mb-3">
                        <label for="birthday" class="form-label">
                            Birthday
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="6" width="18" height="15" rx="2"
                                        stroke="currentColor" stroke-width="2" />
                                    <path d="M3 10H21" stroke="currentColor" stroke-width="2" />
                                    <path d="M8 3V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M16 3V7" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror"
                                id="birthday" wire:model="birthday">
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                Status <span class="required">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                wire:model="status" required>
                                <option value="active">Active</option>
                                <option value="inactive" selected>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">
                                Role <span class="required">*</span>
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role"
                                wire:model="role" required>
                                <option value="user" selected>User</option>
                                <option value="admin">Admin</option>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            Update User
                        </button>
                    </div>

                </div>
            </div>

    </form>
</div>
