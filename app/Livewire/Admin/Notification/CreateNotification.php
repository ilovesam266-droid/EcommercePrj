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
    protected NotificationRequest $notificationRequest;
    public $title = '';
    public $body = '';
    public $variables = [];
    public $type = 'notification';
    public $scheduled_at;

    public function __construct()
    {
        $this->notificationRequest = new NotificationRequest();
    }

    public function boot(NotificationRepositoryInterface $notification_repository)
    {
        $this->notificationRepository = $notification_repository;
    }

    public function rules()
    {
        return $this->notificationRequest->rules();
    }

    public function messages()
    {
        return $this->notificationRequest->messages();
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
            $this->dispatch('showToast', 'success', 'Success', 'Notification is created successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Notification is created failed!');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Create Notification')]
    public function render()
    {
        return view('admin.pages.notification.create');
    }
}
