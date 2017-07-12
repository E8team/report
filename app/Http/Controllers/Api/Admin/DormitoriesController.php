<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Dormitory;
use App\Models\Student;
use App\Transformers\DormitoryInclassTransformer;
use App\Transformers\StudentTransformer;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends AdminController
{
    /**
     * 获取学生可以获取的宿舍
     * @return \Dingo\Api\Http\Response
     */
    public function availableDormitories(Student $student)
    {
        $this->authorize('getAvailableDormitories', $student);
        $dormitories = app(DormitoryRepositoryInterface::class)->getAvailableDormitories($student);
        return $this->response->collection($dormitories, new DormitoryInclassTransformer());
    }

}
