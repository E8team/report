<?php

namespace App\Transformers;


use App\Models\Student;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{

    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = ['student_profile', 'dormitory'];
    public function transform(Student $student)
    {
        return [
            'id' => $student->id,
            'student_num' => $student->student_num,
            'student_name' => $student->student_name,
            'gender'=>$student->gender,
            'id_card_with_mosaic'=>$student->id_card_with_mosaic,
            'department_class_id' => $student->department_class_id,
            'department_class' => $student->getDepartmentClass()->__toString(),
            'report_time'=>$student->report_time?$student->report_time->toDateTimeString():$student->report_time,
            'created_at' => $student->created_at->toDateTimeString(),
            'updated_at' => $student->updated_at->toDateTimeString()
        ];
    }

    public function includeStudentProfile(Student $student)
    {
        $studentProfile = $student->studentProfile;
        return $this->item($studentProfile, new StudentProfileTransformer());
    }

    public function includeDormitory(Student $student)
    {
        $dormitorySelection = $student->dormitorySelection;
        $dormitory = $student->getDepartmentClass()->dormitories()->where('dormitories.id', $dormitorySelection->dormitory_id)->first();
        return $this->item($dormitory, new DormitoryInclassTransformer());
    }
}
