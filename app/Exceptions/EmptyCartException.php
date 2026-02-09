<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class EmptyCartException extends Exception
{
    public function __construct(string $message = 'Cannot checkout with an empty cart.')
    {
        parent::__construct($message);
    }
}
