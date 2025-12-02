<?php

namespace App\Repository\Eloquent;

use App\Models\Cart;
use App\Repository\Constracts\CartRepositoryInterface;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function getModel()
    {
        return Cart::class;
    }

    public function getCart($userId)
    {
        return $this->model->firstOrCreate(['owner_id' => $userId]);
    }

    public function getUserCartItemById($userId, $itemId){
        $cart = $this->model->where('owner_id', $userId)->first();

        if(!$cart) {
            return null;
        }

        return $cart->cartItems()->where('id', $itemId)->first();
    }

    public function removeCartItem($userId, $itemId){
        $cart = $this->model->where('owner_id', $userId)->first();
        $cartItem = $cart->cartItems()->where('id', $itemId)->delete();
        return $cartItem;
    }

    public function checkItemInCart($userId, $variantId)
    {
        $cart = $this->getCart($userId);

        return $cart->cartItems()
            ->where('product_variant_size_id', $variantId)
            ->first();
    }

    public function addCartItem($userId, $variant_id, $quantity)
    {
        $cart = $this->getCart($userId);

        return $cart->cartItems()->create([
            'owner_id' => $userId,
            'product_variant_size_id' => $variant_id,
            'quantity' => $quantity,
        ]);
    }

    public function getCartItemById($userId, $itemIds){
        $cart = $this->getCart($userId);

        return $cart->cartItems()->whereIn('id', $itemIds)->get();
    }
}
