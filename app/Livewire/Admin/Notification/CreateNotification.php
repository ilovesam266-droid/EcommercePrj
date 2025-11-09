<?php

namespace App\Livewire\Admin\Notification;

use App\Http\Requests\NotificationRequest;
use App\Repository\Constracts\NotificationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateNotification extends Component
{
    protected NotificationRepositoryInterface $notificationRepository;
    public $title = '';
    public $body = '';
    public $variables = [];
    public $type = 'notification';
    public $scheduled_at;

    public function boot(NotificationRepositoryInterface $notification_repository)
    {
        $this->notificationRepository = $notification_repository;
    }

    public function rules()
    {
        return (new NotificationRequest()->rules());
    }

    public function messages()
    {
        return (new NotificationRequest()->messages());
    }

    #[On('save-mail')]
    public function updateBody($content)
    {
        $this->body = $content;
        $this->saveMail();
    }

    public function saveMail()
    {
        $this->validate();
        $notificationData = $this->only([
            'name',
            'type',
            'title',
            'body',
            'variables',
            'scheduled_at',
        ]);
        $notificationData['created_by'] = Auth::id();
        $notification = $this->notificationRepository->create($notificationData);
        if ($notification) {
            session()->flash('message', 'Notification is created successfully!');
        }
    }
    #[Layout('layouts.page-layout')]
    #[Title('Create Notification')]
    public function render()
    {
        return view('admin.pages.notification.create');
    }
}
