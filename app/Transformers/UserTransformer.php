<?php

namespace App\Transformers;


use App\Models\User;
use App\Services\Admin\UserService;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = ['user_profile'];
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'student_num' => $user->student_num,
            'student_name' => $user->student_name,
            'gender'=>$user->gender,
            'id_card_with_mosaic'=>$user->id_card_with_mosaic,
            'department_class_id' => $user->department_class_id,
            'department_class' => $user->getDepartmentClass(),
            'report_time'=>$user->report_time?$user->report_time->toDateTimeString():$user->report_time,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }

    public function includeUserProfile(User $user)
    {
        $userProfile = $user->userProfile;
        return $this->item($userProfile, new UserProfileTransformer());
    }

}
