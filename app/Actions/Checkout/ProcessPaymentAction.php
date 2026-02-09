<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Exceptions\PaymentFailedException;
use Illuminate\Support\Str;

class ProcessPaymentAction
{
    public function execute(float $amount, string $paymentMethod): string
    {
        if ($amount <= 0) {
            throw new PaymentFailedException('Payment amount must be greater than zero.');
        }

        usleep(500000);

        return 'TXN_' . strtoupper(Str::random(16));
    }
}
