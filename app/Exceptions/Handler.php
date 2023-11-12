<?php

namespace App\Exceptions;

use Core\Domain\Exceptions\EntityNotFoundException;
use Core\Domain\Exceptions\UuidValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response as HttpResponse;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // buscar um jeito de usar a interface das exceptions do FW?
        if ($e instanceof UuidValidationException) {
            return response()->json([
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => $e->getMessage()
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($e instanceof EntityNotFoundException) {
            return response()->json([
                'status' => HttpResponse::HTTP_NOT_FOUND,
                'message' => $e->getMessage()
            ], HttpResponse::HTTP_NOT_FOUND);
        }

        parent::render($request, $e);
    }
}
