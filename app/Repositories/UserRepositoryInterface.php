<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * 搜索学生(支持拼音和中文)
     */
    public function searchUsers($partOfStudentName, $limit=10, $columns=['*']);
    public function studentNameExist($studentName);
}