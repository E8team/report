<?php

namespace App\Providers;

use App\Events\CancelDorm;
use App\Events\LoginLogger;
use App\Events\SelectedDorm;
use App\Events\StudentReported;
use App\Events\UserAllowedStudentReport;
use App\Events\UserCanceledStudentDorm;
use App\Events\UserCanceledStudentReport;
use App\Events\UserSelectedStudentDorm;
use App\Events\UserSetStudentArrivedDorm;
use App\Events\UserSetStudentReported;
use App\Listeners\LoggerListener;
use App\Listeners\StudentListener;
use Illuminate\Auth\Events\Login;
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
            // StudentListener::class,
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
            // StudentListener::class,
            LoggerListener::class
        ],
        UserSelectedStudentDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserCanceledStudentDorm::class => [
            StudentListener::class,
            LoggerListener::class
        ],
        UserCanceledStudentReport::class => [
            // StudentListener::class,
            LoggerListener::class
        ],
        UserSetStudentArrivedDorm::class => [
            // StudentListener::class,
            LoggerListener::class
        ],
        UserAllowedStudentReport::class => [
            LoggerListener::class
        ],
        Login::class => [
            StudentListener::class
        ],
        LoginLogger::class => [
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
