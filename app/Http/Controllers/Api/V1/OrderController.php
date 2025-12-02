<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\OrderStatus;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Api\V1\Payment\Stripe\StripePaymentController;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\OrderTransformer;
use App\Repository\Constracts\CartRepositoryInterface;
use App\Repository\Constracts\OrderItemRepositoryInterface;
use App\Repository\Constracts\OrderRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use App\Repository\Constracts\UserRepositoryInterface;
use App\Repository\Eloquent\CartRepository;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends BaseApiController
{
    protected OrderRepositoryInterface $orderRepo;
    protected OrderItemRepositoryInterface $orderItemRepo;
    protected ProductVariantSizeRepositoryInterface $variantRepo;
    protected UserRepositoryInterface $userRepo;
    protected CartRepositoryInterface $cartRepo;
    public function __construct(
        OrderRepositoryInterface $order_repo,
        ProductVariantSizeRepositoryInterface $variant_repo,
        OrderItemRepositoryInterface $item_repo,
        UserRepositoryInterface $user_repo,
        CartRepositoryInterface $cart_repo,
    ) {
        parent::__construct();
        $this->orderRepo = $order_repo;
        $this->orderItemRepo = $item_repo;
        $this->variantRepo = $variant_repo;
        $this->userRepo = $user_repo;
        $this->cartRepo = $cart_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->searchFilterPerpage($request);

        $user = $this->userRepo->find(Auth::id());
        $orders = $user->orders;
        if ($orders->isEmpty()) {
            return $this->error("No order retrived.");
        }

        return $this->success($orders, 'Order list retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    //is lacked of add default address of this user
    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            if (isset($validated['cart_item_ids'])) {
                $userId = Auth::id();
                $cartItems = $this->cartRepo->getCartItemById($userId, $validated['cart_item_ids']);
                $validatedItems = $this->validateItems($cartItems);
            } else {
                $variant = $this->variantRepo->find((int)$validated['variant_id']);

                $validatedItems = [[
                    'variant_id' => $variant->id,
                    'qty'        => $validated['qty'],
                    'price'      => $variant->price,
                ]];
            }
            $pricing = $this->calculate($validatedItems);

            $order = $this->orderRepo->create([
                'owner_id' => Auth::id(),
                'province' => $validated['province'],
                'district' => $validated['district'],
                'ward' => $validated['ward'],
                'detailed_address' => $validated['detailed_address'],
                'recipient_name' => $validated['recipient_name'],
                'recipient_phone' => $validated['recipient_phone'],
                'shipping_fee' => $pricing['shipping_fee'],
                'total_amount' => $pricing['total'],
                'status' => OrderStatus::PENDING,
                'customer_note' => $validated['customer_note'],
            ]);

            foreach ($validatedItems as $item) {
                $this->orderItemRepo->create([
                    'order_id' => $order->id,
                    'product_variant_size_id' => $item['variant_id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                ]);

                $this->reduceStock($item['variant_id'], $item['qty']);
            }

            $paymentController = app(StripePaymentController::class);

            $paymentResponse = $paymentController->createPaymentIntent(new Request([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
            ]));

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success($order, 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userRepo->find(Auth::id());
        $order = $user->orders()->find($id);
        if (!$order) {
            return $this->error('Order is not exist');
        }

        return $this->success($order, 'Order is displayed successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $order = $this->orderRepo->delete($id);
        if (!$order) {
            return $this->error('Order deleted failed.');
        }
        return $this->success($order, 'Order deleted successfully.');
    }

    public function validateItems($items)
    {
        $variantId = $items->pluck('product_variant_size_id')->all();

        $variants = $this->variantRepo->getByIdsForUpdate($variantId);

        $validated = [];
        foreach ($items as $item) {
            $variant = $variants[$item->product_variant_size_id];

            if ($variant->stock < $item->quantity) {
                return $this->error('Your buying is not enough stock to sell');
            }

            $validated[] = [
                'variant_id' => $item->product_variant_size_id,
                'qty' => $item->quantity,
                'price' => $variant->price,
            ];
        }
        return $validated;
    }

    public function reduceStock($variantId, $qty)
    {
        $updated = $this->variantRepo->reduceStock($variantId, $qty);

        if (!$updated) {
            throw ValidationException::withMessages([
                'stock' => 'Can not decrement stock, please try again.',
            ]);
        }
    }

    public function calculate($items)
    {
        $subtotal = collect($items)->sum(fn($i) => $i['qty'] * $i['price']);

        $discount = 0;
        $shipping = 30000;

        $total = $subtotal - $discount + $shipping;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_fee' => $shipping,
            'total' => $total,
        ];
    }
}
