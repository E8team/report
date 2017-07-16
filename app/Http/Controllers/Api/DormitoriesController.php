<?php

namespace App\Http\Controllers\Api;

use App\Models\Dormitory;
use App\Models\Student;
use App\Transformers\DormitoryInclassTransformer;
use App\Transformers\StudentTransformer;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends StudentBaseController
{
    /**
     * 获取当前登录的新生可以获取的宿舍
     * @return \Dingo\Api\Http\Response
     */
    public function availableDormitories()
    {
        $student = $this->guard()->user();
        $dormitories = app(DormitoryRepositoryInterface::class)->getAvailableDormitories($student);
        return $this->response->collection($dormitories, new DormitoryInclassTransformer());
    }

    /**
     * 获取选择该宿舍的学生
     * @param Dormitory $dormitory
     * @return \Dingo\Api\Http\Response
     */
    public function students(Dormitory $dormitory)
    {
        $studentIds = $dormitory->dormitorySelections->pluck('student_id');
        return $this->response->collection(Student::find($studentIds), (new StudentTransformer())->myClassId($this->guard()->user()->department_class_id))
            ->addMeta('dorm_num', $dormitory->dorm_num);
    }
}