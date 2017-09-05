<?php

namespace App\Http\Controllers\Api\Admin;


use App\Events\UserAllowedStudentReport;
use App\Events\UserCanceledAllowStudentReport;
use App\Events\UserCanceledStudentDorm;
use App\Events\UserCanceledStudentReport;
use App\Events\UserSelectedStudentDorm;
use App\Events\UserSetStudentArrivedDorm;
use App\Events\UserSetStudentReported;
use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;
use App\Transformers\StudentTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class StudentsController extends AdminController
{

    public function allowReport(Student $student)
    {

        $this->validatePermission('admin.allow_report');
        if (!$student->isAllowReport()) {
            $student->allow_report_at = Carbon::now();
            event(new UserAllowedStudentReport($student, $this->guard()->user()));
            $student->save();
        }
        return $this->response->noContent();
    }

    public function cancelAllowReport(Student $student)
    {
        $this->validatePermission('admin.cancel_allow_report');
        if ($student->isAllowReport()) {
            $this->cancelReport($student);
            $student->allow_report_at = null;
            event(new UserCanceledAllowStudentReport($student, $this->guard()->user()));
            $student->save();
        }
        return $this->response->noContent();
    }

    public function searchStudents($keywords, StudentRepositoryInterface $userRepository)
    {
        $this->validatePermission('admin.show');
        $user = $this->guard()->user();
        if ($user->isSuperAdmin()) {
            $departmentId = null;
        } else {
            $departmentId = $user->getDepartmentId();
        }
        if (is_numeric($keywords)) {
            $students = $userRepository->searchStudentsByStudentNum($keywords, $departmentId, 10, ['id', 'student_name', 'student_num']);
        } else {
            $students = $userRepository->searchStudents($keywords, $departmentId, 10, ['id', 'student_name', 'student_num']);

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
        $student->report_at = Carbon::now();
        event(new UserSetStudentReported($student, $this->guard()->user()));
        $student->save();
        return $this->response->noContent();
    }

    /**
     * 取消报到
     * @param Student $student
     * @return \Dingo\Api\Http\Response
     */
    public function cancelReport(Student $student)
    {
        $this->authorize('cancelReport', $student);
        if (!is_null($student->report_at)) {
            if (!is_null($student->arrive_dorm_at))
                $student->arrive_dorm_at = null;
            $this->cancelDorm($student);
            $student->report_at = null;
            event(new UserCanceledStudentReport($student, $this->guard()->user()));
            $student->save();
        }
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
        if (!is_null($student->dormitorySelection)) {
            $oldDormitoryId = $student->dormitorySelection->dormitory_id;
            $student->dormitorySelection->delete();
            event(new UserCanceledStudentDorm($student, $oldDormitoryId, $this->guard()->user()));
        }
        return $this->response->noContent();
    }

    /**
     * 获取未到达宿舍的学生
     * @param null $departmentId
     * @return \Dingo\Api\Http\Response
     */
    public function notArriveDormStudents($departmentId = null)
    {
        $this->validatePermission('admin.show');
        $user = $this->guard()->user();
        if (!$user->isSuperAdmin() || is_null($departmentId)) {
            $departmentId = $user->getDepartmentId();
        }
        $students = Student::byDepartment($departmentId)->whereNotNull('report_at')->whereNull('arrive_dorm_at')->get();
        Response::getTransformer()->getAdapter()->disableEagerLoading();
        return $this->response->collection($students, (new StudentTransformer())->needPinyin());
    }

    /**
     * 设置学生到达宿舍
     */
    public function setArriveDorm(Student $student, Request $request)
    {
        $this->authorize('setArriveDorm', $student);
        if (is_null($student->arrive_dorm_at)) {
            $this->validate($request, ['bed_num' => 'required|integer']);
            $bedNum = $request->get('bed_num');
            $dormitorySelection = DormitorySelection::findOrFail($student->id);
            if ($bedNum > $dormitorySelection->dormitory->galleryful || $bedNum < 1) {
                throw new ValidationHttpException(['bed_num' => "该床位号应该在 {$bedNum} 到 {$dormitorySelection->dormitory->galleryful} 之间"]);
            }
            $bedNums = DormitorySelection::where('dormitory_id', $dormitorySelection->dormitory_id)->get(['bed_num'])->filter();
            if ($bedNums->contains($bedNum)) {
                throw new ValidationHttpException(['bed_num' => "该床位号已经被选！"]);
            }
            $student->arrive_dorm_at = Carbon::now();
            event(new UserSetStudentArrivedDorm($student, $this->guard()->user(), $bedNum));
            $student->save();
        }
        return $this->response->noContent();
    }
}
