<?php

namespace App\Repositories;


use App\Models\DepartmentClass;

interface DepartmentClassRepositoryInterface
{
    /**
     * 获取班级
     * @param $departmentClassId
     * @return DepartmentClass
     */
    public function getDepartmentClass($departmentClassId);

    /**
     * 从缓存中获取班级
     * @param $departmentClassId
     * @return DepartmentClass
     */
    public function getDepartmentClassFromCache($departmentClassId);
}