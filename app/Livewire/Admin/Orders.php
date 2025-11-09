<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\OrderRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected OrderRepositoryInterface $orderRepository;
    public string $search = '';
    public array $filter = [
        'status' => '',
        'payment_method' => '',
    ];
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

    public function confirmDelete($orderId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm order deletion',
            'Are you sure you want to delete this order <<#ORD'.$orderId.'>>?',
            'delete-order',
            ['order_id' => $orderId],
        );
    }

    #[On('delete-order')]
    public function deleteOrder($data)
    {
        $orderId = $data['order_id'];
        $this->orderRepository->delete($orderId);
        $this->dispatch('showToast', 'success', 'Success','Order Deleted');
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
    public function orders(){
        return $this->orderRepository->all(
            $this->orderRepository->getFilteredOrder($this->filter, $this->search),
            $this->sort,
            $this->perPage,
            ['*'],
            ['owner', 'payment'],
            false
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Orders')]
    public function render()
    {
        $orderFiltersConfig = [
            ['key' => 'status', 'placeholder' => 'Filter by Status', 'options' => [
                ['label' => 'Pending', 'value' => 'pending'],
                ['label' => 'Confirmed', 'value' => 'confirmed'],
                ['label' => 'Cancelled', 'value' => 'canceled'],
                ['label' => 'Shipping', 'value' => 'shipping'],
                ['label' => 'Failed', 'value' => 'failed'],
                ['label' => 'Done', 'value' => 'done'],
            ]],
            ['key' => 'payment_method', 'placeholder' => 'Filter by Payment Method', 'options' => [
                ['label' => 'Cash on delivery', 'value' => 'cash on delivery'],
                ['label' => 'Credit Card', 'value' => 'credit card'],
                ['label' => 'Paypal', 'value' => 'paypal'],
                ['label' => 'Bank Transfer', 'value' => 'bank transfer'],
            ]],
        ];
        return view('admin.pages.orders', compact('orderFiltersConfig'));
    }
}
