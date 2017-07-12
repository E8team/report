<?php


namespace App\Events;


use App\Models\Student;
use App\Models\User;

/**
 * 后台管理员取消学生已选择的宿舍会触发此event
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

    public function log()
    {
    }
}
