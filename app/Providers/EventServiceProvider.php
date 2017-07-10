<?php

namespace App\Providers;

use App\Events\CancelDorm;
use App\Events\SelectedDorm;
use App\Events\StudentReported;
use App\Listeners\StudentListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        StudentReported::class => [
            StudentListener::class
        ],
        SelectedDorm::class => [
            StudentListener::class
        ],
        CancelDorm::class => [
            StudentListener::class
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
