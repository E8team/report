<?php

namespace App\Http\Controllers\Api;

use App\Models\Dormitory;
use App\Models\Student;
use App\Transformers\DormitoryTransformer;
use App\Transformers\StudentTransformer;
use Auth;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends ApiController
{
    public function lists()
    {
        $student = Auth::user();
        $dormitories = app(DormitoryRepositoryInterface::class)->getDormitories($student);
        return $this->response->collection($dormitories, new DormitoryTransformer());
    }

    public function students(Dormitory $dormitory)
    {
        // todo 不同班级的需要显示班级名称
        $studentIds = $dormitory->dormitorySelections->pluck('student_id');
        return $this->response->collection(Student::find($studentIds), new StudentTransformer());
    }
}