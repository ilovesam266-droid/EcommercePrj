<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    #[Computed()]
    public function users(){
        return User::published()->get();
    }
    #[Layout('layouts.page-layout')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('admin.pages.user');
    }
}
