<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        $this->renderable(function (\Exception $e, $request) {
            $response = [
                'status' => 500,
                'message' => $e->getMessage(),
                'fields' => [],
            ];

            if (is_array($data = json_decode($e->getMessage(), true))) {
                $response = array_merge($response, $data);
            }

            if (config('app.debug')) {
                $response['file'] = $e->getFile();
                $response['line'] = $e->getLine();
            }

            return response()->json($response, $response['status']);
        });
    }
}
