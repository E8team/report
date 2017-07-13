<?php

namespace App\Events;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * 登录事件 此事件专门用来记录log
 */
class LoginLogger implements LoggerInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loginEvent;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Login $login)
    {
        $this->loginEvent = $login;
        $this->user = $login->user;
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
        return LoggerInterface::NORMAL_LOG;
    }

    public function log()
    {
        $user = $this->loginEvent->user;
        if($user instanceof Student)
        {
            return "{$user->student_name}({$user->student_num}) 登录了";
        }else if($user instanceof User){
            return "{$user->name}({$user->roles->first()->display_name}) 登录了";
        }
        return false;
    }

    public function departmentId()
    {
        return $this->loginEvent->user->getDepartmentId();
    }
}
