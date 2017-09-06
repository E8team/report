<?php

namespace App\Transformers;


use App\Models\Dormitory;
use App\Models\Student;
use App\Repositories\DormitoryRepository;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{

    private $needPinyin;
    private $myClassId = null;
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = ['student_profile', 'dormitory'];

    public function __construct($needPinyin = false)
    {
        $this->needPinyin = $needPinyin;
    }

    public function needPinyin()
    {
        $this->needPinyin = true;
        return $this;
    }

    public function myClassId($departmentClassId)
    {
        $this->myClassId = $departmentClassId;
        return $this;
    }

    public function transform(Student $student)
    {
        $data = [
            'id' => $student->id,
            'student_num' => $student->student_num,
            'student_name' => $student->student_name,
            'gender' => $student->gender,
            'gender_str'=> $student->gender?'女':'男',
            'id_card' => $student->id_card,
            'id_card_with_mosaic' => $student->id_card_with_mosaic,
            'department_class_id' => $student->department_class_id,
            'department_class' => $student->getDepartmentClass()->__toString(),
            'report_at' => $student->report_at ? $student->report_at->toDateTimeString() : $student->report_at,
            'arrive_dorm_at' => $student->arrive_dorm_at ? $student->arrive_dorm_at->toDateTimeString() : $student->arrive_dorm_at,
            'allow_report_at' => $student->allow_report_at ? $student->allow_report_at->toDateTimeString() : $student->allow_report_at,
            'created_at' => $student->created_at->toDateTimeString(),
            'updated_at' => $student->updated_at->toDateTimeString()
        ];
        if($this->needPinyin)
        {
            $data = array_merge($data, [
                'abbreviation_pinyin1' => $student->abbreviation_pinyin1,
                'abbreviation_pinyin2' => $student->abbreviation_pinyin2,
                'full_pinyin1' => $student->full_pinyin1,
                'full_pinyin2' => $student->full_pinyin2,
            ]);
        }

        if(!is_null($this->myClassId) && $student->department_class_id != $this->myClassId)
        {
            $data = array_merge($data, [
                'diff_class_name' => $student->getDepartmentClass()->__shortName()
            ]);
        }
        return $data;
    }

    public function includeStudentProfile(Student $student)
    {
        $studentProfile = $student->studentProfile;
        return $this->item($studentProfile, new StudentProfileTransformer());
    }

    public function includeDormitory(Student $student)
    {
        $dormitorySelection = $student->dormitorySelection;
        if (is_null($dormitorySelection)) {
            return $this->null();
        } else {
            $dormitory = app(DormitoryRepository::class)->getAvailableDormitories($student)->where('id', $dormitorySelection->dormitory_id)->first();
            return $this->item($dormitory, new DormitoryInclassTransformer());
        }
    }
}
