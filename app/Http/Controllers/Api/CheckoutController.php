<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\CheckoutDTO;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
    ) {
    }

    public function store(CheckoutRequest $request): JsonResponse
    {
        $dto = CheckoutDTO::fromRequest($request);

        $order = $this->checkoutService->handle($dto);

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}