<?php

namespace App\Policies;

use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Models\Student;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use DB;

class DormitoryPolicy
{
    use HandlesAuthorization;


    public function selectDorm(Student $student, Dormitory $dormitory)
    {
        if(!$student->hasBeenReport())
            throw new AuthorizationException('您还没有报到！');
        if(DormitorySelection::where('student_id', $student->id)->count()>0)
            throw new AuthorizationException('你已经选完宿舍了！');

        $departmentClassDormitory = DB::table('department_class_dormitory')
            ->where('department_class_id', $student->department_class_id)
            ->where('dormitory_id', $dormitory->id)
            ->first();
        if(is_null($departmentClassDormitory))
            throw new AuthorizationException('该宿舍不属于您的班级！');
        if($departmentClassDormitory->galleryful <= $departmentClassDormitory->already_selected_num)
            throw new AuthorizationException('该宿舍已经住满了！');
        return true;
    }

    public function reSelectDorm(Student $student, Dormitory $dormitory)
    {
        if(!$student->hasBeenReport())
            throw new AuthorizationException('您还没有报到！');
        if($student->hasBeenArriveDorm())
            throw new AuthorizationException('到达宿舍后无法自行更改宿舍！如需更改请联系迎新服务站！');
        $dormitorySelection = $student->dormitorySelection;
        if($dormitorySelection == null)
            throw new AuthorizationException('您还没有选择宿舍！');
        $departmentClassDormitory = DB::table('department_class_dormitory')
            ->where('department_class_id', $student->department_class_id)
            ->where('dormitory_id', $dormitory->id)
            ->first();
        if(is_null($departmentClassDormitory))
            throw new AuthorizationException('该宿舍不属于您的班级！');
        if($departmentClassDormitory->galleryful <= $departmentClassDormitory->already_selected_num)
            throw new AuthorizationException('该宿舍已经住满了！');
        return true;
    }
}
