<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

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

    public function logLevel()
    {
        return LoggerInterface::NEED_SHOW_LOG;
    }

    public function log()
    {
        return "{$this->student->student_name}({$this->student->student_num}) 取消选择了宿舍";
    }

    public function departmentId()
    {
        return $this->student->getDepartmentId();
    }
}
