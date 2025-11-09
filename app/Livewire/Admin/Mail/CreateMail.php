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
    public $title = '';
    public $body = '';
    public $variables = [];
    public $type = 'notification';
    public $scheduled_at;

    public function boot(MailRepositoryInterface $mail_repository)
    {
        $this->mailRepository = $mail_repository;
    }

    public function rules()
    {
        return (new MailRequest()->rules());
    }

    public function messages()
    {
        return (new MailRequest()->messages());
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
            session()->flash('message', 'Mail is created successfully!');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Create Mail')]
    public function render()
    {
        return view('admin.pages.mail.create');
    }
}
