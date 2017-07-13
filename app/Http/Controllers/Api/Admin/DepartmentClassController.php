<?php


namespace App\Http\Controllers\Api\Admin;


use App\Models\Student;
use App\Repositories\DepartmentClassRepositoryInterface;
use App\Transformers\DepartmentClassTransformer;
use Illuminate\Auth\Access\AuthorizationException;

class DepartmentClassController extends AdminController
{

    public function overview($departmentId = null, DepartmentClassRepositoryInterface $departmentClassRepository)
    {
        //$this->getDepartmentClassStudentCount(1);
        $this->validatePermission('admin.overview');
        $user = $this->guard()->user();
        if (!$user->isSuperAdmin() || is_null($departmentId)) {
            $departmentId = $user->getDepartmentId();
        }
        $data = [];

        $grade = $departmentClassRepository->grades($departmentId)->where('title', date('Y'))->first();
        $majors = $departmentClassRepository->majors($grade);
        $queryBuilder = null;
        $allStudentCount = 0;
        $allStudent = 0;
        foreach ($majors as $major) {
            $majorStudentCount = 0;
            $majorReportedStudentCount = 0;
            $classes = $departmentClassRepository->classNums($major);
            $data['classes'] = [];
            foreach ($classes as $class) {
                $queryBuilder = Student::where('department_class_id', $class->id);
                $studentCount = $queryBuilder->count();
                $reportedStudentCount = $queryBuilder->whereNotNull('report_at')->count();
                $data['classes'][] = [
                    'title' => "{$major->getTitle()}({$class->title})班",
                    'student_count' => $studentCount,
                    'reported_student_count' => $reportedStudentCount
                ];
                $majorStudentCount += $studentCount;
                $majorReportedStudentCount += $reportedStudentCount;
            }
            $data['majors'][] = [
                'title' => $major->title,
                'student_count' => $majorStudentCount,
                'reported_student_count' => $majorReportedStudentCount
            ];

        }
        $data['student_count'] = $queryBuilder->count();
        $data['reported_student_count'] = $queryBuilder->whereNotNull('report_at')->count();

        return $data;
    }

    public function allDepartments(DepartmentClassRepositoryInterface $departmentClassRepository)
    {
        if(!$this->guard()->user()->isSuperAdmin())
            throw new AuthorizationException();
        return $this->response->collection($departmentClassRepository->allDepartments(), new DepartmentClassTransformer());
    }


    private function getDepartmentClassStudentCount($departmentClassId)
    {
        $counts = [];
        $allDepartments = app(DepartmentClassRepositoryInterface::class)->allDepartments();
        dd($allDepartments);
    }
}