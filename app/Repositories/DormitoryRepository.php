<?php

namespace App\Repositories;

use App\Models\DepartmentClass;
use App\Models\Student;
use Cache;

class DormitoryRepository implements DormitoryRepositoryInterface
{

    public function getAvailableDormitories(Student $student)
    {
        return $this->getDormitoriesFromCache($student->department_class_id)->where('dormitories.gender', $student->gender);
    }

    public function getDormitoriesFromCache($departmentClass)
    {
        if ($departmentClass instanceof DepartmentClass) {
            $departmentClass = $departmentClass->id;
        }
        // cache 问题
        // return Cache::rememberForever('department_class_dormitories:'.$departmentClass, function () use($departmentClass){
        return app(DepartmentClassRepositoryInterface::class)->getDepartmentClass($departmentClass)->dormitories()->orderBy('dorm_num')->get();
        // });
    }
}
