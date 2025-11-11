<?php

namespace App\Livewire\Admin;

use App\Enums\CommentStatus;
use App\Repository\Constracts\CommentRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    protected CommentRepositoryInterface $commentRepository;
    public string $search = '';
    public array $filter = [
        'rating' => '',
        'type' => '',
    ];
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;


    public function boot(CommentRepositoryInterface $comment_repository)
    {
        $this->commentRepository = $comment_repository;
    }

    public function approveComment($commentId)
    {
        $data['status'] = CommentStatus::APPROVED;
        $this->commentRepository->update($commentId, $data);
        $this->dispatch('showToast', 'success', 'Success', 'Comment Approved');
    }

    public function rejectComment($commentId)
    {
        $data['status'] = CommentStatus::REJECTED;
        $this->commentRepository->update($commentId, $data);
        $this->dispatch('showToast', 'warning', 'Success', 'Comment Rejected');
    }

    public function confirmDelete($commentId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm comment deletion',
            'Are you sure you want to delete this comment <<#RVW' . $commentId . '>>?',
            'delete-comment',
            ['comment_id' => $commentId],
        );
    }

    #[On('delete-comment')]
    public function deleteComment($data)
    {
        $commentId = $data['comment_id'];
        $this->commentRepository->delete($commentId);
        $this->dispatch('showToast', 'success', 'Success', 'Comment Deleted');
    }

    #[On('searchPerformed')]
    public function updatedSearchTemp($searchTemp)
    {
        $this->search = $searchTemp;
    }

    #[On('filterPerformed')]
    public function updatedSelectedFilter($selectedFilter)
    {
        $this->filter = array_merge($this->filter, $selectedFilter);
    }

    //after search
    #[On('resetPage')]
    public function Search()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function comments()
    {
        return $this->commentRepository->all(
            $this->commentRepository->getFilteredComment($this->filter, $this->search),
            $this->sort,
            $this->perPage,
            ['*'],
            ['user', 'blog'],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Comments')]
    public function render()
    {
        $commentFiltersConfig = [
            [
                'key' => 'status',
                'placeholder' => 'Filter by Status',
                'options' => [
                    ['label' => 'Pending', 'value' => 'pending'],
                    ['label' => 'Approved', 'value' => 'approved'],
                    ['label' => 'Rejected', 'value' => 'rejected'],
                ],
            ],
            [
                'key' => 'type',
                'placeholder' => 'Filter by Type',
                'options' => [
                    ['label' => 'Comment', 'value' => 'comment'], // parent_id null
                    ['label' => 'Reply', 'value' => 'reply'],     // parent_id not null
                ],
            ],
        ];

        return view('admin.pages.comments', compact('commentFiltersConfig'));
    }
}
