<?php

namespace App\Transformers;


use App\Models\User;
use App\Services\Admin\UserService;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'student_num' => $user->student_num,
            'student_name' => $user->student_name,
            'gender'=>$user->gender,
            'id_card_with_mosaic'=>$user->id_card_with_mosaic,
            'department_class_id' => $user->department_class_id,
            'report_time'=>$user->report_time?:$user->report_time->toDateTimeString(),
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }

    public function includeUserProfile(User $user)
    {
        $userProfile = $user->userProfile;
        return $this->collection($userProfile, new UserProfileTransformer());
    }

}
