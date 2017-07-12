<?php


namespace App\Events;

use App\Models\Dormitory;
use App\Models\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 学生选择宿舍后会触发此event
 */
class SelectedDorm implements LoggerInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;
    public $dormitory;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student, Dormitory $dormitory)
    {
        $this->student = $student;
        $this->dormitory = $dormitory;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function log()
    {
        return "{$this->student->student_name}({$this->student->student_num}) 选择了 {$this->dormitory->dorm_num} 宿舍";
    }
}
