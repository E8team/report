<?php
namespace App\Repositories;

interface StudentRepositoryInterface
{
    /**
     * 搜索学生(支持拼音和中文)
     */
    public function searchStudents($partOfStudentName, $departmentId, $limit=10, $columns=['*']);
    public function studentNameExist($studentName);
}