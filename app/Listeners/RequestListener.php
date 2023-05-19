<?php

namespace App\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Log;

class RequestListener
{
    private $log;

    /**
     * Create the event listener.
     */
    public function __construct() {
        $this->log = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/requests.log'),
        ]);
    }

    /**
     * Handle the event.
     */
    public function handle(RequestHandled $event): void
    {
        $request = $event->request;
        $response = $event->response;

        $statusCode = $response->getStatusCode();

        $logText = "{$request->getMethod()} {$request->path()} => {$statusCode}";
        $logData = $request->except('password', 'password_confirm');

        $this->log->info($logText, $logData);
    }
}
