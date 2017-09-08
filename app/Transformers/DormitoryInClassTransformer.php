<?php

namespace App\Transformers;

use App\Models\Dormitory;
use League\Fractal\TransformerAbstract;

class DormitoryInclassTransformer extends TransformerAbstract
{
    protected $dormitorySelection = null;
    public function __construct($dormitorySelection = null)
    {
        $this->dormitorySelection = $dormitorySelection;
    }

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
            'already_selected_num_in_this_class' => $dormitory->pivot->already_selected_num,
            'insert_dormitory_num' => $dormitory->insert_dormitory_num,
            'is_together_dormitory' => $dormitory->is_together_dormitory,
            'bed_num' => is_null($this->dormitorySelection)?null:$this->dormitorySelection->bed_num,
            'gender' => $dormitory->gender,
            'created_at' => $dormitory->created_at->toDateTimeString(),
            'updated_at' => $dormitory->updated_at->toDateTimeString()
        ];
    }
}
