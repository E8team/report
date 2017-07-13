<?php


namespace App\Http\Controllers\Api\Admin;


use App\Models\DepartmentClass;
use App\Models\Student;
use App\Repositories\DepartmentClassRepositoryInterface;
use App\Transformers\DepartmentClassTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Cache;

class DepartmentClassController extends AdminController
{

    public function overview($departmentId = null, DepartmentClassRepositoryInterface $departmentClassRepository)
    {
        //todo cache
        $this->validatePermission('admin.overview');
        $user = $this->guard()->user();
        if (!$user->isSuperAdmin() || is_null($departmentId)) {
            $departmentId = $user->getDepartmentId();
        }
        $data = [];
        $data['student_count'] = $this->getStudentCount($departmentId);
        $data['reported_student_count'] = 0;

        $grade = $departmentClassRepository->grades($departmentId)->where('title', date('Y'))->first();
        $majors = $departmentClassRepository->majors($grade);

        foreach ($majors as $major) {
            $majorReportedStudentCount = 0;
            $classes = $departmentClassRepository->classes($major);
            $data['classes'] = [];
            foreach ($classes as $class) {
                $reportedStudentCount = Student::where('department_class_id', $class->id)->whereNotNull('report_at')->count();
                $data['classes'][] = [
                    'title' => "{$major->getTitle()}({$class->title})班",
                    'student_count' => $this->getStudentCount($class),
                    'reported_student_count' => $reportedStudentCount
                ];
                $majorReportedStudentCount += $reportedStudentCount;
            }

            $data['majors'][] = [
                'title' => $major->title,
                'student_count' => $this->getStudentCount($major),
                'reported_student_count' => $majorReportedStudentCount
            ];
            $data['reported_student_count'] += $majorReportedStudentCount;
        }

        return $data;
    }

    /**
     * 获取所有学院
     * @param DepartmentClassRepositoryInterface $departmentClassRepository
     * @return \Dingo\Api\Http\Response
     * @throws AuthorizationException
     */
    public function allDepartments(DepartmentClassRepositoryInterface $departmentClassRepository)
    {
        if (!$this->guard()->user()->isSuperAdmin())
            throw new AuthorizationException();
        return $this->response->collection($departmentClassRepository->allDepartments(), new DepartmentClassTransformer());
    }

    /**
     * 获取学生总数（可以获取指定班级的人数，指定专业的人数或指定学院的人数）
     * @param $departmentClass
     * @return mixed
     */
    private function getStudentCount($departmentClass)
    {
        static $counts = null;
        if(is_null($counts)){
            $counts = Cache::rememberForever('counts', function () {
                $departmentClassRepository = app(DepartmentClassRepositoryInterface::class);
                $counts = [];
                $allDepartments = $departmentClassRepository->allDepartments();
                foreach ($allDepartments as $department) {

                    $grade = $departmentClassRepository->grades($department)->where('title', date('Y'))->first();
                    $counts[$grade->id] = 0;
                    $majors = $departmentClassRepository->majors($grade);
                    foreach ($majors as $major) {
                        $counts[$major->id] = 0;
                        $classes = $departmentClassRepository->classes($major);
                        foreach ($classes as $class) {
                            $counts[$class->id] = Student::byDepartmentClass($class)->count();
                            $counts[$major->id]+=$counts[$class->id];
                        }
                        $counts[$grade->id] += $counts[$major->id];
                    }
                    $counts[$department->id] = $counts[$grade->id];
                }
                return $counts;
            });
        }
        if($departmentClass instanceof DepartmentClass)
            $departmentClass = $departmentClass->id;
        return $counts[$departmentClass];

    }
}