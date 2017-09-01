<?php

namespace App\Repositories;

use App\Models\Student;

class DormitoryRepository implements DormitoryRepositoryInterface
{

    public function getAvailableDormitories(Student $student)
    {
        return $student->getDepartmentClass()->dormitories()->where('dormitories.gender', $student->gender)->orderBy('dorm_num')->get();
    }

}
