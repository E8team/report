<?php

namespace App\Listeners;

use App\Events\StudentReported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StudentReported  $event
     * @return void
     */
    public function handle($event)
    {
        if($event instanceof StudentReported)
        {
            // $event->student
        }
    }
}
