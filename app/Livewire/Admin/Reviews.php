<?php

namespace App\Livewire\Admin;

use App\Enums\ReviewStatus;
use App\Repository\Constracts\ReviewRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    protected ReviewRepositoryInterface $reviewRepository;
    public string $search = '';
    public array $filter = [
        'rating' => '',
        'status' => '',
    ];
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;


    public function boot(ReviewRepositoryInterface $review_repository)
    {
        $this->reviewRepository = $review_repository;
    }

    public function approveReview($reviewId)
    {
        $data['status'] = ReviewStatus::Approved;
        $this->reviewRepository->update($reviewId, $data);
        $this->dispatch('showToast', 'success', 'Success', 'Review Approved');
    }

    public function rejectReview($reviewId)
    {
        $data['status'] = ReviewStatus::Rejected;
        $this->reviewRepository->update($reviewId, $data);
        $this->dispatch('showToast', 'warning', 'Success', 'Review Rejected');
    }

    public function confirmDelete($reviewId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm review deletion',
            'Are you sure you want to delete this review <<#RVW' . $reviewId . '>>?',
            'delete-review',
            ['review_id' => $reviewId],
        );
    }

    #[On('delete-review')]
    public function deleteReview($data)
    {
        $reviewId = $data['review_id'];
        $this->reviewRepository->delete($reviewId);
        $this->dispatch('showToast', 'success', 'Success', 'Review Deleted');
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
    public function reviews()
    {
        return $this->reviewRepository->all(
            $this->reviewRepository->getFilteredReview($this->filter, $this->search),
            $this->sort,
            $this->perPage,
            ['*'],
            ['user', 'product'],
            false,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Reviews')]
    public function render()
    {
        $reviewFiltersConfig = [
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
                'key' => 'rating',
                'placeholder' => 'Filter by Rating',
                'options' => [
                    ['label' => '1 Star', 'value' => '1'],
                    ['label' => '2 Stars', 'value' => '2'],
                    ['label' => '3 Stars', 'value' => '3'],
                    ['label' => '4 Stars', 'value' => '4'],
                    ['label' => '5 Stars', 'value' => '5'],
                ],
            ],
        ];
        return view('admin.pages.reviews', compact('reviewFiltersConfig'));
    }
}
