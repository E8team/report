<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\StudentRepositoryInterface;

class StudentsController extends AdminController
{
    public function searchStudents($keywords, StudentRepositoryInterface $userRepository)
    {
        $this->validatePermission('admin.show');
        $user = $this->guard()->user();
        if($user->isSuperAdmin()){
            $departmentId = null;
        }else{
            $departmentId = $user->department_id;
        }
        if(is_numeric($keywords))
        {
            $students = $userRepository->searchStudentsByStudentNum($keywords, $departmentId,10, ['id', 'student_name', 'student_num']);
        }else{
            $students = $userRepository->searchStudents($keywords, $departmentId,10, ['id', 'student_name', 'student_num']);

        }
        return $students->toArray();
    }


}