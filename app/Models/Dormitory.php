<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
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
