<?php

namespace App\Models;


class Dormitory extends BaseModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gender' => 'boolean',
        'is_together_dormitory' => 'boolean'

    ];

    public function isTogetherDormitory()
    {
        return $this->is_together_dormitory > 0;
    }
}
