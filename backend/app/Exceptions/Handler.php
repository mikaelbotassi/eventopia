<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
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
    }

    public function render($request, Throwable $e):JsonResponse
    {

        if($e instanceof ValidationException){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'error' => $e->errors(),
            ])->setStatusCode(422);
        }

        if($e instanceof MethodNotAllowedException){
            return response()->json([
                'status' => 'error',
                'message' => 'O método solicitado não é uma operação válida',
                'error' => $e->getMessage()
            ])->setStatusCode(405);
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'É necessário fazer login para realizar esta operação',
                'error' => $e->getMessage(),
            ])->setStatusCode(401);
        }

        return response()->json([
            'status' => 'error',
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => 'Ocorreu um erro durante o processamento da solicitação, contate nosso suporte técnico',
            'error' => [
                'code' => 500,
                'description' => 'Ocorreu um erro interno do servidor'
            ]
        ])->setStatusCode(500);
    }

}
