<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Exceptions\EmptyCartException;
use App\Models\Cart;

class CalculateCartTotalAction
{
    public function execute(?Cart $cart): float
    {
        if (!$cart || $cart->items->isEmpty()) {
            throw new EmptyCartException();
        }

        return (float) $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
