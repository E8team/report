<?php

namespace App\Models;


class DepartmentClass extends BaseModel
{
    protected $fillable = ['title', 'short_title', 'sort', 'parent_id'];
    public $timestamps = false;
    public function parent()
    {
        return $this->hasOne(DepartmentClass::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DepartmentClass::class, 'parent_id', 'id');
    }

    public function scopeByParentId($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }


    /**
     * 学院->年级->专业->班级
     * @return string
     */
    public function __toString()
    {
        $str = '('.$this->getTitle().')班';
        if (!is_null($this->parent)) {
            $str = $this->parent->getTitle() . $str;
            /*if (!is_null($this->parent->parent)) {
                $str = $this->parent->parent->getTitle() . '级' . $str;
                if (!is_null($this->parent->parent->parent)) {
                    $str = $this->parent->parent->parent->getTitle() . $str;
                }
            }*/
        }
        return $str;
    }

    public function __shortName()
    {
        $str = $this->getTitle().'班';
        if (!is_null($this->parent)) {
            $str = $this->parent->getTitle() . $str;
        }
        return $str;
    }

    /**
     * --
     * 系别下有多个学生
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getClass()
    {
        return $this;
    }

    public function getGrade()
    {
        return $this->parent;
    }

    public function getMajor()
    {
        return $this->parent->parent;
    }

    public function getDepartment()
    {
        return $this->parent->parent->parent;
    }

    public function getTitle()
    {
        return $this->short_title ?: $this->title;
    }

    public function dormitories()
    {
        return $this->belongsToMany(Dormitory::class)->withPivot(['galleryful', 'already_selected_num']);
    }

    public function DepartmentClassInfo()
    {
        return $this->hasOne(DepartmentClassInfo::class);
    }
}
