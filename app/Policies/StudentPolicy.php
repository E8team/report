<?php

namespace App\Policies;

use App\Exceptions\NotAllowReportException;
use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use DB;

class StudentPolicy
{
    use HandlesAuthorization;

    public function belongTo(User $user, Student $student)
    {
        if ($user->isSuperAdmin())
            return true;

        return $user->getDepartmentId() == $student->getDepartmentId();
    }

    public function setReport(User $user, Student $student)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.set_report'))
            return false;
        if (!$this->belongTo($user, $student))
            return false;
        if ($student->hasBeenReport())
            throw new AuthorizationException('该学生已经完成报到了！');
        return true;
    }

    public function cancelReport(User $user, Student $student)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.cancel_report'))
            return false;
        if (!$this->belongTo($user, $student))
            return false;
        $hasBeenReport = $student->hasBeenReport();
        if (!$hasBeenReport) {
            throw new AuthorizationException('该学生还没有报到！');
        }
        return true;
    }

    public function cancelDorm(User $user, Student $student)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.cancel_dormitory'))
            return false;
        if (!$this->belongTo($user, $student))
            return false;
        if (!$student->hasBeenReport())
            throw new AuthorizationException('该学生还没有报到！');
        return true;
    }

    public function selectDorm(User $user, Student $student, Dormitory $dormitory)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.select_dormitory'))
            return false;
        if (!$this->belongTo($user, $student))
            return false;
        if (!$student->hasBeenReport())
            throw new AuthorizationException('该学生还没有报到！');
        if (DormitorySelection::where('student_id', $student->id)->count() > 0)
            throw new AuthorizationException('该学生已经选完宿舍了！');

        $departmentClassDormitory = DB::table('department_class_dormitory')
            ->where('department_class_id', $student->department_class_id)
            ->where('dormitory_id', $dormitory->id)
            ->first();
        if (is_null($departmentClassDormitory))
            throw new AuthorizationException('该宿舍不属于该学生的班级！');
        if ($departmentClassDormitory->galleryful <= $departmentClassDormitory->already_selected_num)
            throw new AuthorizationException('该宿舍已经住满了！');
        return true;
    }

    public function getAvailableDormitories(User $user, Student $student)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.get_available_dormitories'))
            return false;
        return $this->belongTo($user, $student);
    }

    public function setArriveDorm(User $user, Student $student)
    {
        if(!$student->isAllowReport())
            throw new NotAllowReportException();
        if (!$user->may('admin.set_arrive_dorm'))
            return false;
        return $this->belongTo($user, $student);
    }

}
