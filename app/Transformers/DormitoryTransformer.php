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
            'galleryful' => $dormitory->galleryful,
            'galleryful_in_this_class' => $dormitory->pivot->galleryful,
            'insert_dormitory_num' => $dormitory->insert_dormitory_num,
            'is_together_dormitory' => $dormitory->is_together_dormitory,
            'gender'=>$dormitory->gender,
            'created_at' => $dormitory->created_at->toDateTimeString(),
            'updated_at' => $dormitory->updated_at->toDateTimeString()
        ];
    }
}
