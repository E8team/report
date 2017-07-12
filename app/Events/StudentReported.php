<?php


namespace App\Events;

use App\Models\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 学生报到后会触发此event
 */
class StudentReported implements LoggerInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
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
        return "{$this->student->student_name}({$this->student->student_num}) 完成报到";
    }
}
