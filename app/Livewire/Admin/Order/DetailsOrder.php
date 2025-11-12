<?php

namespace App\Livewire\Admin\Order;

use App\Enums\OrderStatus;
use App\Events\OrderFailed;
use App\Events\OrderShipping;
use App\Events\OrderCancelled;
use App\Events\OrderConfirmed;
use App\Events\OrderDone;
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
    public $payment_method;
    public $payment_status;
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
    public bool $isEditingAdminNote;


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
        $order = $this->orderRepository->find($this->orderId, ['payment']);
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
        $this->payment_method = $order->payment->payment_method;
        $this->payment_status = $order->payment->status;
        $this->payment_transaction_code = $order->payment->transaction_code;
    }


    public function cancelOrder()
    {
        $this->status = OrderStatus::CANCELED;
        $orderStatus['status'] = $this->status;
        $orderStatus['canceled_at'] = now();
        $order = $this->orderRepository->update($this->orderId, $orderStatus);
        $order->load('owner');
        event(new OrderCancelled($order));
    }

    public function confirmOrder()
    {
        $this->status = OrderStatus::CONFIRMED;
        $orderStatus['status'] = $this->status;
        $orderStatus['confirmed_at'] = now();
        $order = $this->orderRepository->update($this->orderId, $orderStatus);
        $order->load('owner');
        event(new OrderConfirmed($order));
    }

    public function shipOrder()
    {
        $this->status = OrderStatus::SHIPPING;
        $orderStatus['status'] = $this->status;
        $orderStatus['shipping_at'] = now();
        $order = $this->orderRepository->update($this->orderId, $orderStatus);
        $order->load('owner');
        event(new OrderShipping($order));
    }

    public function failedOrder()
    {
        $this->status = OrderStatus::FAILED;
        $orderStatus['status'] = $this->status;
        $order = $this->orderRepository->update($this->orderId, $orderStatus);
        $order->load('owner');
        event(new OrderFailed($order));
    }

    public function doneOrder()
    {
        $this->status = OrderStatus::DONE;
        $orderStatus['status'] = $this->status;
        $orderStatus['done_at'] = now();
        $order = $this->orderRepository->update($this->orderId, $orderStatus);
        $order->load('owner');
        event(new OrderDone($order));
    }

    public function saveAdminNote()
    {
        $adminNote['admin_note'] = $this->admin_note;
        $order = $this->orderRepository->update($this->orderId, $adminNote);

        if ($order) {
            $this->dispatch('showToast', 'success', 'Success', 'Update admin note successfully!!!');
            $this->isEditingAdminNote = false;
        }
    }

    public function render()
    {
        return view('admin.pages.order.details');
    }
}
