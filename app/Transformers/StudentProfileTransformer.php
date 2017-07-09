<?php

namespace App\Transformers;


use App\Models\StudentProfile;
use League\Fractal\TransformerAbstract;

class StudentProfileTransformer extends TransformerAbstract
{

    public function transform(StudentProfile $studentProfile)
    {
        return [
            'user_id' => $studentProfile->user_id,
            'graduate_school' => $studentProfile->graduate_school,
            'come_from' => $studentProfile->come_from,
            'tel' => $studentProfile->tel,
            'height' => $studentProfile->height,
            'weight' => $studentProfile->weight,
            'remarks' => $studentProfile->remarks
        ];
    }

}
