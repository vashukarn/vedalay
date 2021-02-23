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
        'phone',
        'current_address',
        'permanent_address',
        'image',
        'due_fee',
        'session',
        'dob',
        'blood_group',
        'caste_category',
        'disability',
        'aadhar_number',
        'guardian_name',
        'guardian_phone',
        'gender',
        'fatheroccupation',
        'fatherincome',
        'documents',
        'motheroccupation',
        'motherincome',
        'transfer_certificate',
        'level_id',
        'fathername',
        'mothername',
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
}
