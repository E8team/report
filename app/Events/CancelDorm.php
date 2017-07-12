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
 * 学生取消选择宿舍后会触发此事件
 */
class CancelDorm implements LoggerInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;
    public $dormitoryId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student, $dormitoryId)
    {
        $this->student = $student;
        $this->dormitoryId = $dormitoryId;
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
