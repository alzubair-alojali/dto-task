<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\CheckoutRequest;

readonly class CheckoutDTO
{
    public function __construct(
        public int $user_id,
        public string $payment_method,
    ) {
    }

    public static function fromRequest(CheckoutRequest $request): self
    {
        return new self(
            user_id: (int) $request->validated('user_id'),
            payment_method: $request->validated('payment_method'),
        );
    }
}
