<?php

namespace App\Repositories;

interface StudentRepositoryInterface
{
    /**
     * 搜索学生(支持拼音和中文)
     */
    public function searchStudents($partOfStudentName, $departmentId = null, $limit = 10, $columns = ['*']);

    public function searchStudentsByStudentNum($studentNum, $departmentId = null, $limit = 10, $columns = ['*']);

    public function studentNameExist($studentName);
}
