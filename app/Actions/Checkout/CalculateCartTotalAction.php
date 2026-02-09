<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Cart;

class CalculateCartTotalAction
{
    public function execute(Cart $cart): float
    {
        return (float) $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
