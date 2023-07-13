<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForeignKeyException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response(parent::getMessage(), 400, ['Content-Type', 'application/json']);
    }
}
