<?php

namespace App\Http\Controllers\Api\Admin;

use App\Events\CancelDorm;
use App\Events\LoggerInterface;
use App\Events\SelectedDorm;
use App\Events\StudentReported;
use App\Events\UserCancelStudentDorm;
use App\Events\UserCancelStudentReport;
use App\Events\UserSelectedStudentDorm;
use App\Events\UserSetStudentReported;
use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;
use App\Transformers\StudentTransformer;
use Carbon\Carbon;

class StudentsController extends AdminController
{
    public function searchStudents($keywords, StudentRepositoryInterface $userRepository)
    {
        $this->validatePermission('admin.show');
        $user = $this->guard()->user();
        if($user->isSuperAdmin()){
            $departmentId = null;
        }else{
            $departmentId = $user->department_id;
        }
        if(is_numeric($keywords))
        {
            $students = $userRepository->searchStudentsByStudentNum($keywords, $departmentId,10, ['id', 'student_name', 'student_num']);
        }else{
            $students = $userRepository->searchStudents($keywords, $departmentId,10, ['id', 'student_name', 'student_num']);

        }
        return $students->toArray();
    }

    public function show(Student $student)
    {
        $this->validatePermission('admin.show');
        $this->authorize('belongTo', $student);
        return $this->response->item($student, new StudentTransformer());
    }

    /**
     * 确定报到
     * @return \Dingo\Api\Http\Response
     */
    public function setReport(Student $student)
    {
        $this->authorize('setReport', $student);
        $student->report_time = Carbon::now();
        event(new UserSetStudentReported($student, $this->guard()->user()));
        $student->save();
        return $this->response->noContent();
    }

    /**
     * 取消报到
     * @param Student $student
     * @return \Dingo\Api\Http\Response
     */
    public function calcelReport(Student $student)
    {
        $this->authorize('cancelReport', $student);
        $this->cancelDorm($student);
        $student->report_time = null;
        event(new UserCancelStudentReport($student, $this->guard()->user()));
        $student->save();
        return $this->response->noContent();
    }

    /**
     * 选择宿舍
     */
    public function selectDorm(Student $student, Dormitory $dormitory)
    {
        $this->authorize('selectDorm', [$student, $dormitory]);
        DormitorySelection::create([
            'student_id' => $student->id,
            'dormitory_id' => $dormitory->id
        ]);

        event(new UserSelectedStudentDorm($student, $dormitory, $this->guard()->user()));
        return $this->response->noContent();
    }

    /**
     * 取消选择宿舍
     */
    public function cancelDorm(Student $student)
    {
        $this->authorize('cancelDorm', $student);
        // todo 取消选择宿舍后 到宿时间是否需要修改
        if(!is_null($student->dormitorySelection)) {
            $oldDormitoryId = $student->dormitorySelection->dormitory_id;
            $student->dormitorySelection->delete();
            event(new UserCancelStudentDorm($student, $oldDormitoryId, $this->guard()->user()));
        }
        return $this->response->noContent();
    }

}