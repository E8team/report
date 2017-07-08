<?php

namespace App\Transformers;


use App\Models\User;
use App\Models\UserProfile;
use App\Services\Admin\UserService;
use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{

    public function transform(UserProfile $userProfile)
    {
        return [
            'user_id' => $userProfile->user_id,
            'graduate_school' => $userProfile->graduate_school,
            'come_from' => $userProfile->come_from,
            'tel' => $userProfile->tel,
            'height' => $userProfile->height,
            'weight' => $userProfile->weight,
            'remarks' => $userProfile->remarks
        ];
    }

}
