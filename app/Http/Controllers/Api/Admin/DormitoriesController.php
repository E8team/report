<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Dormitory;
use App\Models\DormitorySelection;
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


    public function availableBedNum(Student $student)
    {
        $this->authorize('getAvailableBedNum', $student);
        $dormitorySelection = DormitorySelection::findOrFail($student->id);
        $galleryful = $dormitorySelection->dormitory->galleryful;
        $bedNums = DormitorySelection::where('dormitory_id', $dormitorySelection->dormitory_id)->get(['bed_num'])->filter(function ($item) {
            return !is_null($item->bed_num);
        });
        $availableBedNum = array_diff(range(1, $galleryful), $bedNums->toArray());
        return [
            'galleryful' => $galleryful,
            'available_bed_num' => $availableBedNum
        ];
    }

}
