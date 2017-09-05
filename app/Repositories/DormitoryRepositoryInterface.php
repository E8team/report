<?php

namespace App\Repositories;

use App\Models\Student;

interface DormitoryRepositoryInterface
{
    public function getAvailableDormitories(Student $user);

    public function getDormitoriesFromCache($departmentClass);
}