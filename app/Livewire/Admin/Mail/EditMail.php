<?php

namespace App\Livewire\Admin\Mail;

use App\Http\Requests\MailRequest;
use App\Repository\Constracts\MailRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class EditMail extends Component
{
    protected MailRepositoryInterface $mailRepository;
    protected MailRequest $mailRequest;
    public $editingMailId = null;
    public $name = '';
    public $title = '';
    public $body = '';
    public $variables = [];
    public $type = 'notification';
    public $scheduled_at;

    public function __construct()
    {
        $this->mailRequest = new MailRequest();
    }

    public function boot(MailRepositoryInterface $mail_repository)
    {
        $this->mailRepository = $mail_repository;
    }

    public function rules()
    {
        return $this->mailRequest->rules('edit', $this->editingMailId);
    }

    public function messages()
    {
        return $this->mailRequest->messages();
    }

    public function mount($editingMailId)
    {
        $this->editingMailId = (int) $editingMailId;
        $this->loadMail();
    }

    public function loadMail()
    {
        $mail = $this->mailRepository->find($this->editingMailId);
        if ($mail) {
            $this->fill($mail->only([
                'name',
                'title',
                'body',
                'variables',
                'type',
            ]));
            $this->scheduled_at = optional($mail->scheduled_at)->format('Y-m-d\TH:i');
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
        $mailData = $this->only([
            'name',
            'type',
            'title',
            'body',
            'variables',
            'scheduled_at',
        ]);
        $mail = $this->mailRepository->update($this->editingMailId, $mailData);
        if ($mail) {
            $this->dispatch('showToast', 'success', 'Success', 'Mail is updated successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Mail is updated failed!');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Edit Mail')]
    public function render()
    {
        return view('admin.pages.mail.edit');
    }
}
