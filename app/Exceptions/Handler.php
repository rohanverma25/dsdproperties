<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        // Every reported error is also kept in app_error_logs (one row per distinct error, with a count), so it can
        // be reviewed from the database. The normal log still runs too.
        $this->reportable(function (Throwable $e) {
            \App\Support\ErrorLogger::record($e);
        });
    }

    // 404s are not redirected to the homepage: Google treats that as a soft 404
    // and trusts the site less. resources/views/errors/404.blade.php renders the
    // branded page with a real 404 status instead.
}
