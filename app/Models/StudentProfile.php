<?php

namespace App\Models;


class StudentProfile extends BaseModel
{
    protected $fillable = ['student_id', 'graduate_school', 'come_from', 'place_of_student', 'tel'];
    protected $primaryKey = 'student_id';
    public $incrementing = false;
}
