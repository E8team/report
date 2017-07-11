<?php


namespace App\Http\Controllers\Api\Admin;


use App\Repositories\StudentRepositoryInterface;
use App\Transformers\UserTransformer;

class UsersController extends AdminController
{

    public function me()
    {
        return $this->response->item($this->guard()->user(), new UserTransformer());
    }

    public function searchStudents($partOfStudentName, StudentRepositoryInterface $userRepository)
    {
        $this->validatePermission('admin.show');
        $user = $this->guard()->user();
        if($user->isSuperAdmin()){
            $departmentId = null;
        }else{
            $departmentId = $user->department_id;
        }
        $studentNames = $userRepository->searchStudents($partOfStudentName, $departmentId,10, ['student_name']);
        if(!$studentNames->isEmpty()){
            $studentNames = $studentNames->pluck('student_name');
        }
        return $studentNames;
    }

}
