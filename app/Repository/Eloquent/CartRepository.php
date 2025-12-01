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
}
