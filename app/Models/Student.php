<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'session',
        'level_id',
        'dob',
        'blood_group',
        'caste_category',
        'disability',
        'regpriv',
        'aadhar_number',
        'guardian_name',
        'guardian_phone',
        'phone',
        'permanent_address',
        'current_address',
        'gender',
        'image',
        'fathername',
        'fatheroccupation',
        'fatherincome',
        'mothername',
        'motheroccupation',
        'motherincome',
    ];
    protected $dates = ['deleted_at'];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function get_level()
    {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }
    public function get_session()
    {
        return $this->hasOne('App\Models\Session', 'id', 'session');
    }
}
