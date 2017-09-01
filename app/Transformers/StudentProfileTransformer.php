<?php

namespace App\Transformers;


use App\Models\StudentProfile;
use League\Fractal\TransformerAbstract;

class StudentProfileTransformer extends TransformerAbstract
{

    public function transform(StudentProfile $studentProfile)
    {
        return [
            'student_id' => $studentProfile->student_id,
            'graduate_school' => $studentProfile->graduate_school,
            'come_from' => $studentProfile->come_from,
            'place_of_student' => $studentProfile->place_of_student,
            'tel' => $studentProfile->tel,
            'height' => $studentProfile->height,
            'weight' => $studentProfile->weight,
            'remarks' => $studentProfile->remarks
        ];
    }

}
