<?php

namespace App\Models;


class Log extends BaseModel
{
    const NORMAL_LOG = 1;
    const NEED_SHOW_LOG = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_name', 'content', 'serialize_data', 'log_level', 'department_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'serialize_data'
    ];
}
