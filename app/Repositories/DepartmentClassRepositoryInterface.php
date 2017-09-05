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

    public function allDepartments();

    public function grades($department);

    public function majors($grade);

    public function classes($major);

    public function getId($department, $grade, $major, $classNum);

    public function getStudents($departmentClass);
}
