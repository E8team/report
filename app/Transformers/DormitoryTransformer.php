<?php

namespace App\Transformers;

use App\Models\Dormitory;
use League\Fractal\TransformerAbstract;

class DormitoryTransformer extends TransformerAbstract
{
    public function transform(Dormitory $dormitory)
    {
        return [
            'id' => $dormitory->id,
            'dorm_num' => $dormitory->dorm_num,
            'dorm_floor' => $dormitory->dorm_floor,
            'dorm_ridgepole' => $dormitory->dorm_ridgepole,
            'dorm_unit' => $dormitory->dorm_unit,
            'galleryful' => $dormitory->galleryful,
            'galleryful_in_this_class' => $dormitory->pivot->galleryful,
            'already_checked_in_num' => $dormitory->pivot->already_checked_in_num,
            'insert_dormitory_num' => $dormitory->insert_dormitory_num,
            'is_together_dormitory' => $dormitory->is_together_dormitory,
            'gender'=>$dormitory->gender,
            'created_at' => $dormitory->created_at->toDateTimeString(),
            'updated_at' => $dormitory->updated_at->toDateTimeString()
        ];
    }
}
