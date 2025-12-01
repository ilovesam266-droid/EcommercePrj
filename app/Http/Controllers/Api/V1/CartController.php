<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddToCartRequest;
use App\Repository\Constracts\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseApiController
{
    protected CartRepositoryInterface $cartRepo;
    public function __construct(CartRepositoryInterface $cart_repo)
    {
        $this->cartRepo = $cart_repo;
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
}
