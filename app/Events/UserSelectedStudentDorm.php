<?php


namespace App\Events;

use App\Models\Dormitory;
use App\Models\Student;
use App\Models\User;


/**
 * 后台管理员选择学生宿舍后会触发此event
 */
class UserSelectedStudentDorm extends SelectedDorm
{

    public $user;

    public function __construct(Student $student, Dormitory $dormitory, User $user)
    {
        parent::__construct($student, $dormitory);
        $this->user = $user;
    }

    public function log()
    {
        return "{$this->user->name}({$this->user->roles->first()->display_name}) 将 {$this->student->student_name}({$this->student->student_num}) 的宿舍设置为 {$this->dormitory->dorm_num}";
    }
}
