<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\BlogRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Blogs extends Component
{
    use WithPagination;
    protected BlogRepositoryInterface $blogRepository;
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;
    public $blogId = null;

    public function boot(BlogRepositoryInterface $blog_repository)
    {
        $this->blogRepository = $blog_repository;
    }

    protected $listener = [
        'userDeleted' => '$refresh',
    ];

    public function confirmDelete($blogId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm blog deletion',
            'Are you sure you want to delete this blog <<'.$blogId.'>>?',
            'delete-blog',
            ['blog_id' => $blogId],
        );
    }

    #[On('delete-blog')]
    public function deleteBlog($data)
    {
        $blogId = $data['blog_id'];
        $this->blogRepository->delete($blogId);
        $this->dispatch('showToast', 'success', 'Success', 'Blog Deleted');
    }

    #[Computed()]
    public function blogs()
    {
        return $this->blogRepository->all(
            [],
            $this->sort,
            $this->perPage,
            ['*'],
            [
                'user',
            ],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Blogs')]
    public function render()
    {
        return view('admin.pages.blogs');
    }
}
