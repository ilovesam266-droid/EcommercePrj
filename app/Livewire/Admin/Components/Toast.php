<?php

namespace App\Livewire\Admin\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];

    #[On('showToast')]
    public function showToast($type, $title, $message)
    {
        $this->toasts[] = [
            'id' => uniqid(),
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];
    }

    public function removeToast($id)
    {
        $this->toasts = array_filter($this->toasts, fn($t) => $t['id'] !== $id);
    }

    public function render()
    {
        return view('admin.components.toast');
    }
}
