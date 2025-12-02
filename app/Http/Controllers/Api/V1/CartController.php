<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddToCartRequest;
use App\Http\Requests\Api\Cart\UpdateCartItemRequest;
use App\Repository\Constracts\CartRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseApiController
{
    protected CartRepositoryInterface $cartRepo;
    protected ProductVariantSizeRepositoryInterface $variantRepo;
    public function __construct(CartRepositoryInterface $cart_repo, ProductVariantSizeRepositoryInterface $variant_repo)
    {
        $this->cartRepo = $cart_repo;
        $this->variantRepo = $variant_repo;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userId = Auth::id();
        $cart = $this->cartRepo->getCart($userId);

        return $this->success($cart->cartItems, 'Cart retrived successfully.');
    }

    public function addToCart(AddToCartRequest $request)
    {
        $userId = Auth::id();
        $variant_size_id = $request->variant_id;
        $quantity = $request->quantity;

        $cartItem = $this->cartRepo->checkItemInCart($userId, $variant_size_id);

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = $this->cartRepo->addCartItem($userId, $variant_size_id, $quantity);
        }

        return $this->success($cartItem, 'Added to cart successfully');
    }

    public function updateQuantity(UpdateCartItemRequest $request, $itemId)
    {
        $userId = Auth::id();
        $quantity = $request->quantity;
        $cartItem = $this->cartRepo->getUserCartItemById($userId, $itemId);
        $cartItem->quantity = $quantity;

        $orderController = app(OrderController::class);
        $validateQuantity = $orderController->validateItems(collect([$cartItem]));

        if(!$validateQuantity) {
            return $this->error('Not enough stock to sell');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $this->success($cartItem, 'Quantity updated successfully');
    }

    public function removeCartItem($itemId){
        $cartItem = $this->cartRepo->removeCartItem(Auth::id(), $itemId);
        if(!$cartItem){
            return $this->error('Cart Item removed failed.');
        }

        return $this->success($cartItem, 'Cart Item removed successfully.');
    }
}
