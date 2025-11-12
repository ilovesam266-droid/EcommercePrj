<?php

namespace App\Livewire\Admin\Mail;

use Livewire\Component;
use App\Http\Requests\MailRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Repository\Constracts\MailRepositoryInterface;

class CreateMail extends Component
{
    protected MailRepositoryInterface $mailRepository;
    protected MailRequest $mailRequest;
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
        return $this->mailRequest->rules();
    }

    public function messages()
    {
        return $this->mailRequest->messages();
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
        $mailData = $this->only([
            'name',
            'type',
            'title',
            'body',
            'variables',
            'scheduled_at',
        ]);
        $mailData['created_by'] = Auth::id();
        $mail = $this->mailRepository->create($mailData);
        if ($mail) {
            $this->dispatch('showToast', 'success', 'Success', 'Mail is created successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Mail is created failed!');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Create Mail')]
    public function render()
    {
        return view('admin.pages.mail.create');
    }
}
