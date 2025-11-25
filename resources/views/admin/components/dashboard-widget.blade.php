<div class="col-sm-6 col-xl-3">
    <div class="card text-white bg-{{ $color }}">
        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
                <div>
                    <div class="fs-4 fw-semibold">
                        {{ $value }}
                        @if ($icon)
                            <span class="fs-6 fw-normal">
                                <svg class="icon">
                                    <use xlink:href="{{ $icon }}"></use>
                                </svg>
                            </span>
                        @endif
                        @if ($subtext)
                        <span class="fs-6 fw-normal">{{ $subtext }}</span>
                    @endif
                    </div>

                </div>
                <div>{{ $title }}</div>
            </div>

            @if (count($dropdownItems) > 0)
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach ($dropdownItems as $item)
                            <a class="dropdown-item" href="#">{{ $item }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if ($chartId)
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="{{ $chartId }}" height="70"></canvas>
            </div>
        @endif
    </div>
</div>
