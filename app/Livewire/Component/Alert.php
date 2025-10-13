<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Alert extends Component
{
    public $message ='';
    public $type = 'success';
    public $visible = false;

    public function mount(){
        foreach (['success', 'fail', 'info'] as $type) {
            if (session()->has($type)) {
                $this->showAlert($type, session($type));
                break;
            }
        }
    }
    protected $listeners = ['showAlert'=>'showAlert', 'hideAlert'=>'hideAlert'];
    public function showAlert($type, $message){
        $this->type = $type;
        $this->message = $message;
        $this->visible = true;

        $this->dispatch('alert-show');
    }

    public function hideAlert()
    {
        $this->visible = false;
    }
    public function render()
    {
        return view('admin.components.alert');
    }
}
