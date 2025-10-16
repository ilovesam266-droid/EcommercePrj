<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class Search extends Component
{
    public $search = '';
    public function applySearch(){
        $this->dispatch('searching', 'search': $this->search);
    }
    public function render()
    {
        return view('livewire.component.search');
    }
}
