<?php

namespace App\Livewire\Admin\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class ModalConfirm extends Component
{
    public $show = false;
    public $title = 'Xác nhận hành động';
    public $message = 'Bạn có chắc chắn muốn thực hiện hành động này không?';
    public $confirmEvent = null;
    public $payload = [];

    protected $listeners = ['showConfirm' => 'showModal'];

    public function showModal($title, $message, $confirmEvent, $payload = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->confirmEvent = $confirmEvent;
        $this->payload = $payload;
        $this->show = true;
    }

    public function confirm()
    {
        if ($this->confirmEvent) {
            $this->dispatch($this->confirmEvent, $this->payload);
        }
        $this->show = false;
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('admin.components.modals');
    }
}
