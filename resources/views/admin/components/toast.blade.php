<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    @foreach ($toasts as $toast)
        <div class="toast align-items-center border-0 mb-2 show shadow-lg {{ $toast['type'] }}"
            style="min-width: 320px; backdrop-filter: blur(10px);"
            wire:key="{{ $toast['id'] }}"
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-full scale-95"
            @animationend.window="$wire.removeToast('{{ $toast['id'] }}')">
            <div class="d-flex align-items-center p-3">
                <!-- Icon -->
                <div class="toast-icon me-3">
                    @if($toast['type'] === 'success')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    @elseif($toast['type'] === 'error' || $toast['type'] === 'danger')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    @elseif($toast['type'] === 'warning')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    @endif
                </div>

                <!-- Content -->
                <div class="toast-body flex-grow-1">
                    <strong class="d-block mb-1" style="font-size: 0.95rem;">{{ $toast['title'] }}</strong>
                    <span style="font-size: 0.875rem; opacity: 0.9;">{{ $toast['message'] }}</span>
                </div>

                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white ms-2"
                    @click="show = false"
                    aria-label="Close"
                    style="font-size: 0.75rem;"></button>
            </div>

            <!-- Progress Bar -->
            <div class="toast-progress"
                x-data="{ width: 100 }"
                x-init="
                    let duration = 4000;
                    let interval = 50;
                    let step = (interval / duration) * 100;
                    let timer = setInterval(() => {
                        width -= step;
                        if (width <= 0) clearInterval(timer);
                    }, interval);
                "
                :style="`width: ${width}%`">
            </div>
        </div>
    @endforeach
</div>

