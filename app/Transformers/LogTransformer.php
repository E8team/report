<?php

namespace App\Transformers;


use App\Models\Log;
use League\Fractal\TransformerAbstract;

class LogTransformer extends TransformerAbstract
{

    public function transform(Log $log)
    {
        return [
            'id' => $log->id,
            'content' => $log->content,
            'department_id' => $log->department_id,
            'created_at' => $log->created_at->toDateTimeString(),
            'updated_at' => $log->updated_at->toDateTimeString()
        ];
    }
}
