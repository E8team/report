<?php
namespace App\Repositories;

use App\Models\Student;

interface DormitoryRepositoryInterface
{
    public function getDormitories(Student $user);
}