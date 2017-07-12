<?php


namespace App\Http\Controllers\Api\Admin;


use App\Models\Student;
use App\Repositories\DepartmentClassRepositoryInterface;

class DepartmentClassController extends AdminController
{

    public function overview($departmentId = null, DepartmentClassRepositoryInterface $departmentClassRepository)
    {
        $this->validatePermission('admin.overview');
        $user = $this->guard()->user();
        if(!$user->isSuperAdmin() || is_null($departmentId))
        {
            $departmentId = $user->department_id;
        }

        $queryBuilder = Student::byDepartment($departmentId);
        $data = [];
        $data['student_count'] = $queryBuilder->count();
        $data['reported_student_count'] = $queryBuilder->whereNotNull('report_time')->count();

        $grade = $departmentClassRepository->grades($departmentId)->where('title', date('Y'))->first();
        $majors = $departmentClassRepository->majors($grade);
        $classIds = [];
        $queryBuilder = null;
        foreach ($majors as $major){

            $classIds = $departmentClassRepository->classNums($major)->pluck('id');
            $queryBuilder = Student::whereIn('department_class_id',$classIds);
            $temp = [
                'title' => $major->title,
                'short_title' => $major->short_title,
                'student_count' => $queryBuilder->count(),
                'reported_student_count' => $queryBuilder->whereNotNull('report_time')->count()
            ];
            $data['majors'][] = $temp;
        }
        return $data;
    }

}