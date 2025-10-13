<!-- Alerts -->

<div>
    @if ($visible)
        <div class="tab-content rounded-bottom">
            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                @switch($type)
                    @case('success')
                        <div class="alert alert-primary" role="alert">{{ $message }}</div>
                    @break

                    @case('fail')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @break

                    @case('info')
                        <div class="alert alert-info" role="alert">{{ $message }}</div>
                    @break
                @endswitch
            </div>
        </div>
    @endif
</div>
@script
    <script>
        $wire.on('alert-show', () => {
            setTimeout(() => {
                Livewire.emit('hideAlert');
            }, 3000); // 3s ẩn đi
        });
    </script>
@endscript
