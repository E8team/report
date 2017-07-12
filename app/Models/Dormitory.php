<?php

namespace App\Models;


class Dormitory extends BaseModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gender' => 'boolean',
        'is_together_dormitory' => 'boolean'

    ];

    public function isInsertDormitoryNum()
    {
        return $this->insert_dormitory_num > 0;
    }

    /**
     * 获取宿舍的单元号
     * @return mixed
     */
    public function getDormUnitAttribute()
    {
        if ($this->attributes['dorm_num'][0] == '0') {
            return $this->attributes['dorm_num'][1];
        } else {
            return substr($this->attributes['dorm_num'], 0, 2);
        }
    }

    /**
     * 获取宿舍的AB栋
     * @return mixed
     */
    public function getDormRidgepoleAttribute()
    {
        return $this->attributes['dorm_num'][2];
    }

    /**
     * 获取宿舍的楼层
     * @return mixed
     */
    public function getDormFloorAttribute()
    {
        return $this->attributes['dorm_num'][3];
    }

    /**
     * 封装合并的宿舍名
     * @param $value
     * @return mixed
     */
    public function getDormNumAttribute($value)
    {
        $str = $this->dorm_unit . substr($value, 2);

        if ($this->isInsertDormitoryNum()) {
            $str .= '(插)';
        } elseif ($this->is_together_dormitory) {
            $str .= '(合)';
        }
        return $str;
    }

    public function dormitorySelections()
    {
        return $this->hasMany(DormitorySelection::class);
    }
}
