<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\MailRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Mails extends Component
{
    use WithPagination;
    protected MailRepositoryInterface $mailRepository;
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;

    public function boot(MailRepositoryInterface $mail_repository){
        $this->mailRepository = $mail_repository;
    }

    #[Computed()]
    public function mails(){
        return $this->mailRepository->all(
            [],
            $this->sort,
            $this->perPage,
            ['*'],
            ['user'],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Mails')]
    public function render()
    {
        return view('admin.pages.mails');
    }
}
