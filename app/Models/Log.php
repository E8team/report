<?php

namespace App\Models;


class Log extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_name', 'content'
    ];
}
