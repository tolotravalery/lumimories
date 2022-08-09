<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\BougieEventCreated' => ['App\Listeners\BougieListenerCreated'],
        'App\Events\SignalerEvent' => ['App\Listeners\SignalerListener'],
        'App\Events\ContactEventCreated' => ['App\Listeners\ContactListenerCreated'],
        'App\Events\PhotoEventCreated' => ['App\Listeners\PhotoListenerCreated'],
        'App\Events\AnecdoteEventCreated' => ['App\Listeners\AnecdoteListenerCreated'],
        'App\Events\CheckgenealogieEventCreated' => ['App\Listeners\CheckgenealogieListenerCreated'],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
