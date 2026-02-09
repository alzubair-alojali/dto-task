<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Cart;

class ClearCartAction
{
    public function execute(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
