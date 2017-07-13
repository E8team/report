<?php

namespace App\Models;


class Feedback extends BaseModel
{

    const FEEDBACK_TYPE_BUG = 0;
    const FEEDBACK_TYPE_IMPROV = 1;
    const FEEDBACK_TYPE_OTHER = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['feedback_type', 'contact', 'content', 'user_id', 'student_id'];
}
