<?php

namespace App\Providers;

use App\Events\SeriesCreated;
use App\Listeners\EmailUserSeriesCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O array de eventos para listeners.
     *
     * @var array
     */
    protected $listen = [
        SeriesCreated::class => [
            EmailUserSeriesCreated::class,
        ],
    ];

    /**
     * Registra quaisquer eventos para seu aplicativo.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}