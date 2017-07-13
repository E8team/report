<?php

namespace App\Repositories;


use App\Models\DepartmentClass;
use Cache;

class DepartmentClassRepository implements DepartmentClassRepositoryInterface
{
    public function getDepartmentClassWithoutCache($departmentClassId)
    {
        return DepartmentClass::findOrFail($departmentClassId)->load('parent.parent.parent');
    }

    public function getDepartmentClass($departmentClassId)
    {
        return Cache::rememberForever('department_class:' . $departmentClassId, function () use ($departmentClassId) {
            return $this->getDepartmentClassWithoutCache($departmentClassId);
        });
    }

    public function allDepartmentsWithoutCache()
    {
        return DepartmentClass::byParentId(0)->orderBy('title')->get();
    }

    public function allDepartments()
    {
        return Cache::rememberForever('all_departments', function () {
            return $this->allDepartmentsWithoutCache();
        });
    }

    public function gradesWithoutCache($department)
    {
        if ($department instanceof DepartmentClass) {
            $builder = $department->children();
        } elseif (is_numeric($department)) {
            $builder = DepartmentClass::byParentId($department);
        }
        return $builder->orderBy('title')->get();
    }

    public function grades($department)
    {
        if ($department instanceof DepartmentClass) {
            $department = $department->id;
        }
        return Cache::rememberForever('grades:' . $department, function () use ($department) {
            return $this->gradesWithoutCache($department);
        });
    }

    public function majorsWithoutCache($grade)
    {
        if ($grade instanceof DepartmentClass) {
            $builder = $grade->children();
        } elseif (is_numeric($grade)) {
            $builder = DepartmentClass::byParentId($grade);
        }
        return $builder->orderBy('title')->get();

    }

    public function majors($grade)
    {
        if ($grade instanceof DepartmentClass) {
            $grade = $grade->id;
        }
        return Cache::rememberForever('majors:' . $grade, function () use ($grade) {
            return $this->majorsWithoutCache($grade);
        });
    }

    public function classesWithoutCache($major)
    {
        if ($major instanceof DepartmentClass) {
            $builder = $major->children();
        } elseif (is_numeric($major)) {
            $builder = DepartmentClass::byParentId($major);
        }
        return $builder->orderBy('title')->get();
    }

    public function classes($major)
    {
        if ($major instanceof DepartmentClass) {
            $major = $major->id;
        }

        return Cache::rememberForever('classess:' . $major, function () use ($major) {
            return $this->classesWithoutCache($major);
        });
    }
}