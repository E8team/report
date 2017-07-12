<?php


namespace App\Events;


use App\Models\Student;
use App\Models\User;

/**
 * 后台管理员取消学生已选择的宿舍会触发此event
 */

class UserCancelStudentDorm extends CancelDorm
{

    public $user;

    public function __construct(Student $student, $dormitoryId, User $user)
    {
        parent::__construct($student, $dormitoryId);
        $this->user = $user;
    }
}