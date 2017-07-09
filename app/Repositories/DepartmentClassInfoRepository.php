<?php

namespace App\Repositories;



use App\Models\DepartmentClass;
use App\Models\DepartmentClassInfo;
use App\Models\Student;

class DepartmentClassInfoRepository implements DepartmentClassInfoRepositoryInterface
{
    public function get($departmentClassId)
    {
        $departmentClassInfo = DepartmentClassInfo::where('department_class_id', $departmentClassId)->first();
        if(is_null($departmentClassInfo)){
            $departmentClass = DepartmentClass::findOrFail($departmentClassId);
            $dormitories = $departmentClass->dormitories()->where('dormitories.insert_dormitory_num', 0)->where('dormitories.is_together_dormitory', false)->get();
            $boyNormalDormFinished = true;
            $dormitories->where('gender', Student::GENDER_BOY)->each(function ($item) use(&$boyNormalDormFinished){
                if($item->pivot->galleryful!=$item->pivot->already_checked_in_num){
                    $boyNormalDormFinished = false;
                    return false;
                }
            });
            $gailNormalDormFinished = true;
            $dormitories->where('gender', Student::GENDER_GAIL)->each(function ($item) use(&$gailNormalDormFinished){
                if($item->pivot->galleryful!=$item->pivot->already_checked_in_num){
                    $gailNormalDormFinished = false;
                    return false;
                }
            });

            $departmentClassInfo = DepartmentClassInfo::create([
                'department_class_id' => $departmentClassId,
                'boy_normal_dorm_finished' => $boyNormalDormFinished,
                'girl_normal_dorm_finished' => $gailNormalDormFinished
            ]);
        }
        return $departmentClassInfo;
    }
}