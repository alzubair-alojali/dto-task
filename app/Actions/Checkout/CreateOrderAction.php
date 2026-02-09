<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class CreateOrderAction
{
    public function execute(User $user, Cart $cart, float $totalAmount, string $transactionId): Order
    {
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'completed',
            'payment_reference' => $transactionId,
        ]);

        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price_at_purchase' => $cartItem->product->price,
            ]);
        }

        return $order->load('items.product');
    }
}
