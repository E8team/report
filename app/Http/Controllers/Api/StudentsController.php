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
use Illuminate\Http\Request;

class StudentsController extends StudentBaseController
{
    public function searchStudents($partOfStudentName, StudentRepositoryInterface $userRepository)
    {
        $studentNames = $userRepository->searchStudents($partOfStudentName, null, 10, ['student_name']);
        if (!$studentNames->isEmpty()) {
            $studentNames = $studentNames->pluck('student_name');
        }
        return $studentNames;
    }

    public function studentNameExist($studentName, StudentRepositoryInterface $userRepository)
    {
        if ($userRepository->studentNameExist($studentName)) {
            return $this->response->noContent();
        } else {
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
    public function setReport(Request $request)
    {
        $this->authorize('set-report');
        $this->validate($request, [
            'height' => 'required|numeric|between:0,250',
            'weight' => 'required|numeric|between:0,250'
        ], [
            'height.required' => '请输入身高',
            'height.numeric' => '身高必须为数字',
            'height.between' => '身高必须在 :min ~ :max 之间',
            'weight.required' => '请输入体重',
            'weight.numeric' => '体重必须为数字',
            'weight.between' => '体重必须在 :min ~ :max 之间',
        ]);

        $student = $this->guard()->user();
        $student->report_at = Carbon::now();
        event(new StudentReported($student));
        $student->save();
        $student->studentProfile()->update($request->only('height', 'weight'));
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
        if (!is_null($student->dormitorySelection)) {
            $oldDormitoryId = $student->dormitorySelection->dormitory_id;
            $student->dormitorySelection->delete();
            event(new CancelDorm($student, $oldDormitoryId));
        }
        return $this->response->noContent();
    }
}