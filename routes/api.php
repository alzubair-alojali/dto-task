<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
