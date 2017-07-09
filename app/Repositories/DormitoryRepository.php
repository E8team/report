<?php
namespace App\Repositories;

use App\Models\Student;

class DormitoryRepository implements DormitoryRepositoryInterface
{

    public function getDormitories(Student $user)
    {
        return $user->getDepartmentClass()->dormitories()->where('dormitories.gender', $user->gender)->get();
    }

}