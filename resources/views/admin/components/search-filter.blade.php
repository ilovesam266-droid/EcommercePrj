<div class="filter-card p-4">
    <div class="row g-3 flex">
        <div class="col-md-4 flex-grow-1">
            <div class="input-group ">
                <span class="input-group-text">
                    <svg class="c-icon" width="16" height="16">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-search"></use>
                    </svg>
                </span>
                <input type="text" class="form-control" placeholder="{{ $placeholderSearch }}" wire:model="searchTemp">
            </div>
        </div>
        @foreach($filterConfigs as $filter)
            <div class="col-md-3 flex-grow-1">
                <select class="form-select" wire:model="selectedFilter.{{ $filter['key'] }}">
                    <option value=""> All {{ $filter['key'] }} </option>
                    @foreach($filter['options'] as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        <div class="col-md-2 d-flex align-items-end flex-grow-1">
            <button wire:click="btnSearch" class="btn btn-primary w-100">
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
