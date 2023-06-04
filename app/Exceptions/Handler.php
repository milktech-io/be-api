<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
    }

    public function render($request, Throwable $exception)
    {
        $msg = null;
        $type = get_class($exception);
        if ($type == 'Illuminate\\Validation\\ValidationException') {
            $msg = 'Los datos son inválidos';
            $status = 422;
        } elseif (
            $type == 'Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException'
            || $type == 'Illuminate\\Database\\Eloquent\\ModelNotFoundException') {
            $status = 404;
        } else {
            $status = 500;
        }
        $data = [
            'line' => $exception->getLine(),
            'type' => $type,
            'file' => $exception->getFile(),
            'service' => env('APP_NAME'),
            'trace' => $exception->getTrace(),
        ];

        if ($status == 422) {
            $data['errors'] = $exception->errors();
        }

        return  setResponse((object) [
            'code' => $status,
            'msg' => $msg ?? $exception->getMessage(),
            'data' => $data,
        ]);
    }
}
