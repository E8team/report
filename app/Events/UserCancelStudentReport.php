<?php


namespace App\Events;


use App\Models\Student;
use App\Models\User;

/**
 * 后台管理员设置为未报到会触发此event
 */
class UserCancelStudentReport implements LoggerInterface
{

    public $studen;
    public $user;

    public function __construct(Student $student, User $user)
    {
        $this->student = $student;
        $this->user = $user;
    }

    public function logLevel()
    {
        return LoggerInterface::NEED_SHOW_LOG;
    }

    public function log()
    {
        return "{$this->user->name}({$this->user->roles->first()->display_name}) 将 {$this->student->student_name}({$this->student->student_num}) 设置为未报到";
    }

    public function departmentId()
    {
        return $this->user->getDepartmentId();
    }
}
