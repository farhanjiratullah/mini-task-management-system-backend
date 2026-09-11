<?php

use App\Support\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $isJsonRequest = fn (Request $request) => $request->is('api/*') || $request->expectsJson();

        $exceptions->shouldRenderJsonWhen($isJsonRequest);

        $exceptions->render(function (ValidationException $e, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return ApiResponse::error($e->getMessage(), $e->status, $e->errors());
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return ApiResponse::error('Resource not found.', 404);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request) && ! config('app.debug')) {
                return ApiResponse::error('Something went wrong.', 500);
            }
        });
    })->create();
