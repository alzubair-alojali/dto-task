<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Checkout\CalculateCartTotalAction;
use App\Actions\Checkout\ClearCartAction;
use App\Actions\Checkout\CreateOrderAction;
use App\Actions\Checkout\ProcessPaymentAction;
use App\DTOs\CheckoutDTO;
use App\Exceptions\EmptyCartException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(
        private readonly CalculateCartTotalAction $calculateCartTotal,
        private readonly ProcessPaymentAction $processPayment,
        private readonly CreateOrderAction $createOrder,
        private readonly ClearCartAction $clearCart,
    ) {
    }

    public function handle(CheckoutDTO $dto): Order
    {
        $user = User::findOrFail($dto->user_id);

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new EmptyCartException();
        }

        $totalAmount = $this->calculateCartTotal->execute($cart);

        $transactionId = $this->processPayment->execute($totalAmount, $dto->payment_method);

        $order = DB::transaction(function () use ($user, $cart, $totalAmount, $transactionId) {
            $order = $this->createOrder->execute($user, $cart, $totalAmount, $transactionId);

            $this->clearCart->execute($cart);

            return $order;
        });

        return $order;
    }
}
