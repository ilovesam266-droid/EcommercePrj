<?php

namespace App\Livewire\Admin\Order;

use App\Repository\Constracts\OrderRepositoryInterface;
use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Component;

class DetailsOrder extends Component
{
    protected OrderRepositoryInterface $orderRepository;
    protected UserRepositoryInterface $userRepository;
    public $orderId = null;
    public $owner_id;
    public $status;
    public $formatted_price;
    public $formatted_shipping_fee;
    public $formatted_total;
    public $recipient_name;
    public $recipient_phone;
    public $full_address;
    public $payment_method_label;
    public $payment_status_label;
    public $payment_transaction_code;
    public $customer_note;
    public $admin_note;
    public $cancellation_reason;
    public $failure_reason;
    public $created_at;
    public $updated_at;
    public $confirmed_at;
    public $shipping_at;
    public $canceled_at;
    public $failed_at;
    public $done_at;


    public function boot(OrderRepositoryInterface $order_repository, UserRepositoryInterface $user_repository)
    {
        $this->orderRepository = $order_repository;
        $this->userRepository = $user_repository;
    }

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        $order = $this->orderRepository->find($this->orderId);
        if ($order) {
            $this->fill($order->only([
                'owner_id',
                'status',
                'formatted_price',
                'formatted_shipping_fee',
                'formatted_total',
                'recipient_name',
                'recipient_phone',
                'full_address',
                'payment_method_label',
                'payment_status_label',
                'payment_transaction_code',
                'customer_note',
                'admin_note',
                'cancellation_reason',
                'failure_reason',
                'created_at',
                'updated_at',
                'confirmed_at',
                'shipping_at',
                'canceled_at',
                'failed_at',
                'done_at',
            ]));
        }
    }

    public function render()
    {
        return view('admin.pages.order.details');
    }
}
