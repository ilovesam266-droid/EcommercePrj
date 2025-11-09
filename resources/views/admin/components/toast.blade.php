{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toast Demo</title>
    <style>
        /* --- Container --- */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
        }

        /* --- Toast Box --- */
        .toast {
            background: #fff;
            border-radius: 10px;
            padding: 16px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            pointer-events: all;
            position: relative;
            opacity: 0;
            /* Start hidden, fade in via animation */
            overflow: hidden;
            min-width: 280px;
        }

        .toast-icon {
            font-size: 22px;
        }

        .toast-content {
            flex-grow: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .toast-message {
            font-size: 14px;
            color: #555;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: currentColor;
            width: 100%;
            animation: progressBar linear forwards;
        }

        .toast.success {
            color: #16a34a;
            border-left: 4px solid #16a34a;
        }

        .toast.error {
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .toast.warning {
            color: #f59e0b;
            border-left: 4px solid #f59e0b;
        }

        .toast.info {
            color: #2563eb;
            border-left: 4px solid #2563eb;
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(120%);
                opacity: 0;
            }
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }

            to {
                width: 0;
            }
        }

        /* Pause progress when hover */
        .toast:hover .toast-progress {
            animation-play-state: paused;
        }
    </style>
</head>

<body>

    <div class="toast-container"></div>

    <button onclick="showToast('success', 'Thành công', 'Dữ liệu đã được lưu!')">Success</button>
    <button onclick="showToast('error', 'Lỗi', 'Không thể lưu dữ liệu!')">Error</button>
    <button onclick="showToast('warning', 'Cảnh báo', 'Dữ liệu chưa đầy đủ!')">Warning</button>
    <button onclick="showToast('info', 'Thông tin', 'Đang xử lý yêu cầu...')">Info</button>

    <script>
        class Toast {
            constructor(type, title, message, duration = 3000) {
                this.type = type;
                this.title = title;
                this.message = message;
                this.duration = duration;
                this.element = this.createElement();
            }

            createElement() {
                const toast = document.createElement("div");
                toast.classList.add("toast", this.type);

                toast.innerHTML = `
                    <div class="toast-icon">
                        ${this.getIcon()}
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${this.title}</div>
                        <div class="toast-message">${this.message}</div>
                    </div>
                    <div class="toast-progress" style="animation-duration:${this.duration}ms"></div>
                    `;

                // Hover pause/resume
                toast.addEventListener("mouseenter", () => clearTimeout(this.timer));
                toast.addEventListener("mouseleave", () => {
                    this.timer = setTimeout(() => this.remove(), this.duration / 2);
                });

                return toast;
            }

            getIcon() {
                switch (this.type) {
                    case "success":
                        return "✅";
                    case "error":
                        return "❌";
                    case "warning":
                        return "⚠️";
                    case "info":
                        return "ℹ️";
                    default:
                        return "🔔";
                }
            }

            show() {
                const container = document.querySelector(".toast-container");
                container.appendChild(this.element);
                this.timer = setTimeout(() => this.remove(), this.duration);
            }

            remove() {
                this.element.style.animation = "slideOut 0.4s ease forwards";
                setTimeout(() => this.element.remove(), 400);
            }
        }

        function showToast(type, title, message) {
            const toast = new Toast(type, title, message);
            toast.show();
        }
    </script>

</body>

</html> --}}
{{-- <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    @foreach ($toasts as $toast)
        <div class="toast align-items-center text-bg-light border-0 mb-2 show shadow {{ $toast['type'] }}"
            style="min-width: 300px;" wire:key="{{ $toast['id'] }}" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
            x-show="show" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
            @animationend.window="$wire.removeToast('{{ $toast['id'] }}')">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>{{ $toast['title'] }}</strong><br>
                    <span>{{ $toast['message'] }}</span>
                </div>
            </div>
        </div>
    @endforeach

</div> --}}
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

