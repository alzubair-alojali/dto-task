<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentFailedException extends Exception
{
    public function __construct(string $message = 'Payment processing failed.')
    {
        parent::__construct($message);
    }
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_PAYMENT_REQUIRED);
    }
}
