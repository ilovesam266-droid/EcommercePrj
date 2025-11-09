<div>
    <!-- Modal -->
    <div class="modal fade @if($show) show d-block @endif" tabindex="-1" @if($show) style="background:rgba(0,0,0,0.5);" @endif
    wire:click.self="cancel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title text-white">{{ $title }}</h5>
                    <button type="button" class="btn-close" wire:click="cancel"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $message }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="cancel">Hủy</button>
                    <button class="btn btn-danger" wire:click="confirm">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Ngăn cuộn khi modal mở -->
@if($show)
    <script>
        document.body.classList.add('modal-open');
    </script>
@else
    <script>
        document.body.classList.remove('modal-open');
    </script>
@endif
