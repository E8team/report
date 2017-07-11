<?php

namespace App\Http\Controllers\Api;


use App\Events\CancelDorm;
use App\Events\SelectedDorm;
use App\Events\StudentReported;
use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Repositories\StudentRepositoryInterface;
use App\Transformers\StudentTransformer;
use Carbon\Carbon;

class StudentsController extends StudentBaseController
{
    public function searchStudents($partOfStudentName, StudentRepositoryInterface $userRepository)
    {
        $studentNames = $userRepository->searchStudents($partOfStudentName, null,10, ['student_name']);
        if(!$studentNames->isEmpty()){
            $studentNames = $studentNames->pluck('student_name');
        }
        return $studentNames;
    }

    public function studentNameExist($studentName, StudentRepositoryInterface $userRepository)
    {
        if($userRepository->studentNameExist($studentName)){
            return $this->response->noContent();
        }else{
            return $this->response->errorNotFound('该学生不存在！');
        }
    }

    public function me()
    {
        return $this->response->item($this->guard()->user(), new StudentTransformer());
    }

    /**
     * 确定报到
     * @return \Dingo\Api\Http\Response
     */
    public function setReport()
    {
        $this->authorize('set-report');
        $student = $this->guard()->user();
        $student->report_time = Carbon::now();
        event(new StudentReported($student));
        $student->save();
        return $this->response->noContent();
    }

    /**
     * 选择宿舍
     */
    public function selectDorm(Dormitory $dormitory)
    {
        $this->authorize('selectDorm', $dormitory);
        $student = $this->guard()->user();

        DormitorySelection::create([
            'student_id' => $student->id,
            'dormitory_id' => $dormitory->id
        ]);

        event(new SelectedDorm($student, $dormitory));
        return $this->response->noContent();
    }

    /**
     * 取消选择宿舍
     */
    public function cancelDorm()
    {
        $this->authorize('cancel-dorm');
        $student = $this->guard()->user();
        $oldDormitoryId = $student->dormitorySelection->dormitory_id;
        $student->dormitorySelection->delete();
        event(new CancelDorm($student, $oldDormitoryId));
        return $this->response->noContent();
    }
}