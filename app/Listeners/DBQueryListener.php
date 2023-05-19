<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class DBQueryListener
{
    private $log;

    /**
     * Create the event listener.
     */
    public function __construct() {
        $this->log = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/de_queries.log'),
        ]);
    }

    /**
     * Handle the event.
     */
    public function handle(QueryExecuted $event): void
    {
        $this->log->info($event->sql, $event->bindings);
    }
}
