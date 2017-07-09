<?php

namespace App\Http\Controllers\Api;


use App\Repositories\StudentRepositoryInterface;
use App\Transformers\StudentTransformer;
use Auth;

class StudentsController extends ApiController
{
    public function searchStudents($partOfStudentName, StudentRepositoryInterface $userRepository)
    {
        $studentNames = $userRepository->searchStudents($partOfStudentName, 10, ['student_name']);
        if(!$studentNames->isEmpty()){
            $studentNames = $studentNames->pluck('student_name');
        }
        return $studentNames;
    }

    public function studentNameExist($studentName, StudentRepositoryInterface $userRepository)
    {
        if($userRepository->studentNameExist($studentName)){
            return $this->response->noContent();
        }else{
            return $this->response->errorNotFound('该学生不存在！');
        }
    }

    public function me()
    {
        return $this->response->item(Auth::user(), new StudentTransformer());
    }

    public function setReport()
    {
        $student = Auth::user();
    }
}