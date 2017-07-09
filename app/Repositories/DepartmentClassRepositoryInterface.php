<?php

namespace App\Repositories;


interface DepartmentClassRepositoryInterface
{
    public function getDepartmentClass($departmentClassId);
    public function getDepartmentClassFromCache($departmentClassId);
}