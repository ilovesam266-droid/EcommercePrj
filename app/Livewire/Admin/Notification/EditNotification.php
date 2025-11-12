<?php

namespace App\Livewire\Admin\Notification;

use App\Http\Requests\NotificationRequest;
use App\Repository\Constracts\NotificationRepositoryInterface;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditNotification extends Component
{
    protected NotificationRepositoryInterface $notificationRepository;
    protected NotificationRequest $notificationRequest;
    public $editingNotificationId = null;
    public $name = '';
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

    public function mount($editingNotificationId)
    {
        $this->editingNotificationId = (int) $editingNotificationId;
        $this->loadNotification();
    }

    public function loadNotification()
    {
        $notification = $this->notificationRepository->find($this->editingNotificationId);
        if ($notification) {
            $this->fill($notification->only([
                'name',
                'title',
                'body',
                'variables',
                'type',
            ]));
            $this->scheduled_at = optional($notification->scheduled_at)->format('Y-m-d\TH:i');
        }
    }

    #[On('updateMail')]
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
        $notification = $this->notificationRepository->update($this->editingNotificationId, $notificationData);
        if ($notification) {
            $this->dispatch('showToast', 'success', 'Success', 'Notification is updated successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Notification is updated failed!');
        }
    }


    #[Layout('layouts.page-layout')]
    #[Title('Edit Notification')]
    public function render()
    {
        return view('admin.pages.notification.edit');
    }
}
