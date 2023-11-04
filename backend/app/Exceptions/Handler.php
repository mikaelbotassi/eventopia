<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof MethodNotAllowedException){
            return response()->json([
                'error' => $e->getMessage()
            ])->setStatusCode(405);
        }

        return response()->json([
            'error' => $e->getMessage()
        ])->setStatusCode(500);
    }

}
