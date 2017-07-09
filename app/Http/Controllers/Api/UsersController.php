<?php

namespace App\Http\Controllers\Api;


use App\Repositories\UserRepositoryInterface;
use App\Transformers\UserTransformer;
use Auth;

class UsersController extends ApiController
{
    public function searchUser($partOfStudentName, UserRepositoryInterface $userRepository)
    {
        $studentNames = $userRepository->searchUsers($partOfStudentName, 10, ['student_name']);
        if(!$studentNames->isEmpty()){
            $studentNames = $studentNames->pluck('student_name');
        }
        return $studentNames;
    }

    public function studentNameExist($studentName, UserRepositoryInterface $userRepository)
    {
        if($userRepository->studentNameExist($studentName)){
            return $this->response->noContent();
        }else{
            return $this->response->errorNotFound('该学生不存在！');
        }
    }

    public function me()
    {
        return $this->response->item(Auth::user(), new UserTransformer());
    }
}