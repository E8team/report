<?php

namespace App\Repositories;

use App\Models\Student;
use Cache;

class DormitoryRepository implements DormitoryRepositoryInterface
{

    public function getAvailableDormitories(Student $student)
    {
        $availableDormitories = Cache::rememberForever('available_dormitories:' . $student->id, function () use ($student) {
            return $student->getDepartmentClass()->dormitories()->orderBy('dorm_num')->get();
        });
        return $availableDormitories->where('dormitories.gender', $student->gender);
    }
}
