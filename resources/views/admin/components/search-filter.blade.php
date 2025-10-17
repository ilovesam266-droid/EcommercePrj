<div class="filter-card p-4">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="vertical-align: middle; margin-right: 4px;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                Search
            </label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ $placeholderSearch }}" wire:model="searchTemp">
            </div>
        </div>
        @foreach($filterConfigs as $filter)
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                    {{ $filter['placeholder'] }}
                </label>
                <select class="form-select" wire:model="selectedFilter.{{ $filter['key'] }}">
                    <option value=""> All </option>
                    @foreach($filter['options'] as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        <div class="col-md-2 d-flex align-items-end">
            <button wire:click="btnSearch" class="btn btn-secondary w-100">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                Search
            </button>
        </div>
    </div>
</div>
