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

    public function log()
    {
        return "{$this->user->name}({$this->user->roles->first()->display_name}) 取消了 {$this->student->student_name}({$this->student->student_num}) 选择的宿舍";
    }
}