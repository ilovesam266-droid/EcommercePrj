<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    <div wire:ignore>
        <textarea id="editor" class="form-control">{!! $content !!}</textarea>
    </div>
    <div id="editor-feedback" style="font-size: 13px; color: #666; margin-top: 5px;"></div>
</div>
