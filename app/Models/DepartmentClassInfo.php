<?php

namespace App\Models;


class DepartmentClassInfo extends BaseModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'boy_normal_dorm_finished' => 'boolean',
        'girl_normal_dorm_finished' => 'boolean'

    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_class_id', 'boy_normal_dorm_finished', 'girl_normal_dorm_finished'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
