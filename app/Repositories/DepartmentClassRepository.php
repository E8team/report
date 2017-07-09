<?php

namespace App\Repositories;


use App\Models\DepartmentClass;
use Cache;

class DepartmentClassRepository implements DepartmentClassRepositoryInterface
{
    public function getDepartmentClass($departmentClassId)
    {
        return DepartmentClass::findOrFail($departmentClassId)->load('parent.parent.parent');
    }

    public function getDepartmentClassFromCache($departmentClassId)
    {
        return Cache::rememberForever('department_class:' . $departmentClassId, function () use ($departmentClassId) {
            return $this->getDepartmentClass($departmentClassId);
        });
    }
}