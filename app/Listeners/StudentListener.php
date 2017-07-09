<?php

namespace App\Listeners;

use App\Events\SelectedDorm;
use App\Events\StudentReported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

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
        }elseif($event instanceof SelectedDorm)
        {
            DB::table('department_class_dormitory')
                ->where('department_class_id', $event->student->department_class_id)
                ->where('dormitory_id', $event->dormitory->id)
                ->increment('already_selected_num');
        }
    }
}
