<?php


namespace App\Events;

use App\Models\Student;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * 后台管理员将学生设置为到达宿舍后触发此event
 */
class UserSetStudentArrivedDorm implements LoggerInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student, User $user)
    {
        $this->student = $student;
        $this->user = $user;
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
        return '';
    }
}