<?php

namespace App\Providers;

use App\Listeners\{DBQueryListener, RequestListener};
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        if (config('app.debug')) {
            Event::listen(QueryExecuted::class, DBQueryListener::class);
            Event::listen(RequestHandled::class, RequestListener::class);
        }
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
