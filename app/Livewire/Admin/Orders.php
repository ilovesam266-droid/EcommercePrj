<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\OrderRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected OrderRepositoryInterface $orderRepository;
    public $sort = ['created_at' => 'asc'];
    public $perPage = 5;
    public $detailsOrderId = null;
    public bool $showDetailsModal = false;

    public function boot(OrderRepositoryInterface $repository){
        $this->orderRepository = $repository;
    }

    public function openDetailsModal($orderId)
    {
        $this->detailsOrderId = $orderId;
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->reset(['detailsOrderId']);
    }

    #[Computed()]
    public function orders(){
        return $this->orderRepository->all(
            [],
            $this->sort,
            $this->perPage,
            ['*'],
            ['owner'],
            false
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Orders')]
    public function render()
    {
        return view('admin.pages.orders');
    }
}
