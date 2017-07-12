<?php

namespace App\Listeners;

use App\Events\CancelDorm;
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
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        if($event instanceof SelectedDorm)
        {
            DB::table('department_class_dormitory')
                ->where('department_class_id', $event->student->department_class_id)
                ->where('dormitory_id', $event->dormitory->id)
                ->increment('already_selected_num');
        }elseif ($event instanceof CancelDorm)
        {
            DB::table('department_class_dormitory')
                ->where('department_class_id', $event->student->department_class_id)
                ->where('dormitory_id', $event->dormitoryId)
                ->decrement('already_selected_num');
        }
    }
}
