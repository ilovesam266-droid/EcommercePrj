<?php

namespace App\Livewire\Admin\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class TextEditor extends Component
{
    public $content; // Biến để lưu nội dung từ CKEditor

    public function mount($content = '')
    {
        $this->content = $content;
    }

    #[On('save-content')]
    public function saveContent($value)
    {
        $this->content = $value;
        $this->dispatch('save-mail', $this->content);
    }

    #[On('update-content')]
    public function updatedContent($value)
    {
        $this->content = $value;
        $this->dispatch('updateMail', $this->content);
    }

    public function render()
    {
        return view('admin.components.text-editor');
    }
}
