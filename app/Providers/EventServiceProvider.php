<?php

namespace App\Providers;

use App\Events\CancelDorm;
use App\Events\SelectedDorm;
use App\Events\StudentReported;
use App\Events\UserCancelStudentDorm;
use App\Events\UserCancelStudentReport;
use App\Events\UserSelectedStudentDorm;
use App\Events\UserSetStudentReported;
use App\Listeners\LoggerListener;
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
            StudentListener::class,
            LoggerListener::class
        ],
        SelectedDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        CancelDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserSetStudentReported::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserSelectedStudentDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserCancelStudentDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserCancelStudentReport::class => [
            StudentListener::class,
            LoggerListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
