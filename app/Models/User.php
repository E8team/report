<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gender' => 'boolean'

    ];

    protected $dates = ['report_time', 'arrive_dorm_time', 'created_at', 'updated_at'];

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function dormitorySelection()
    {
        return $this->hasOne(DormitorySelection::class);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->attributes['id_card'];
    }

    private $idCardWithMosaic = null;
    public function getIdCardWithMosaicAttribute()
    {
        if(is_null($this->idCardWithMosaic)){
            $this->idCardWithMosaic = preg_replace('/(\d{6})\d{8}([\dxX]{4})/','$1********$2', $this->attributes['id_card']);
        }
        return $this->idCardWithMosaic;
    }
}
