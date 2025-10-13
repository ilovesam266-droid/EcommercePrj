<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    #[Layout('layouts.page-layout')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('admin.pages.dashboard');
    }
}
