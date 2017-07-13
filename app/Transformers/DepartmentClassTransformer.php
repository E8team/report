<?php

namespace App\Transformers;


use App\Models\DepartmentClass;
use League\Fractal\TransformerAbstract;

class DepartmentClassTransformer extends TransformerAbstract
{

    public function transform(DepartmentClass $departmentClass)
    {
        return [
            'id' => $departmentClass->id,
            'title' => $departmentClass->title,
            'short_title' => $departmentClass->short_title,
        ];
    }

}
