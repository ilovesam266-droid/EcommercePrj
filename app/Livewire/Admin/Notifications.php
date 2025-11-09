<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\NotificationRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;
    protected NotificationRepositoryInterface $notificationRepository;
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;

    public function boot(NotificationRepositoryInterface $notification_repository){
        $this->notificationRepository = $notification_repository;
    }

     #[Computed()]
    public function notifications(){
        return $this->notificationRepository->all(
            [],
            $this->sort,
            $this->perPage,
            ['*'],
            ['user'],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Notifications')]
    public function render()
    {
        return view('admin.pages.notifications');
    }
}
