<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    public function isTogetherDormitory()
    {
        return $this->is_together_dormitory > 0;
    }
}
