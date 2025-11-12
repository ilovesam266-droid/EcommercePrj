<?php

namespace App\Livewire\Admin\Order;

use App\Http\Requests\OrderRequest;
use App\Repository\Constracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class CreateOrder extends Component
{
    protected OrderRepositoryInterface $orderRepository;
    protected OrderRequest $orderRequest;
    public $owner_id = null;
    public $status = 'pending';
    public $total_amount = 0;
    public $shipping_fee = 0;
    public $recipient_name = '';
    public $recipient_phone = '';
    public $province = '';
    public $district ='';
    public $ward ='';
    public $detailed_address ='';
    public $payment_method = 0;
    public $payment_status = 0;
    public $payment_transaction_code;
    public $customer_note = '';
    public $admin_note = '';
    public $confirmed_at = '';
    public $shipping_at;
    public $failed_at;
    public $canceled_at;
    public $done_at;

    public function __construct()
    {
        $this->orderRequest = new OrderRequest();
    }

    public function boot(OrderRepositoryInterface $order_repository)
    {
        $this->orderRepository = $order_repository;
    }

    public function rules()
    {
        return $this->orderRequest->rules();
    }
    public function messages()
    {
        return $this->orderRequest->messages();
    }

    public function createOrder()
    {
        $this->validate();
        $orderData = $this->only([
            'status',
            'total_amount',
            'shipping_fee',
            'recipient_name',
            'recipient_phone',
            'province',
            'district',
            'ward',
            'detailed_address',
            'payment_method',
            'payment_status',
            'payment_transaction_code',
            'customer_note',
            'admin_note',
            'confirmed_at',
            'canceled_at',
            'shipping_at',
            'failed_at',
            'done_at',
        ]);
        $orderData['owner_id'] = Auth::id();
        $order = $this->orderRepository->create($orderData);
        if($order){
            $this->dispatch('showToast', 'success', 'Success', 'Order is created successfully!');
            return redirect()->route('admin.orders');
        }else{
            $this->dispatch('showToast', 'error', 'Error', 'Product is created failed!');
        }

    }

    public function resetForm(){
        $this->reset();
    }

    #[Computed()]
    public function total()
    {
        return $this->total_amount + $this->shipping_fee;
    }

    #[Layout('layouts.page-layout')]
    #[Title('Create Order')]
    public function render()
    {
        return view('admin.pages.order.create');
    }
}
