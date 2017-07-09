<?php

namespace App\Models;


class DormitorySelection extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'dormitory_id'
    ];

    public function student()
    {

        return $this->belongsTo(Student::class);
    }
}