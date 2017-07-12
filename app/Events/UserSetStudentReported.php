<?php


namespace App\Events;

use App\Models\Student;
use App\Models\User;

/**
 * 后台管理员将学生设置为报到后会触发此event
 */
class UserSetStudentReported extends StudentReported
{
    public $user;

    public function __construct(Student $student, User $user)
    {
        parent::__construct($student);
        $this->user = $user;
    }
}