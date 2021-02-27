<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'short_name',
        'user_id',
        'subject',
        'dob',
        'due_salary',
        'joining_date',
        'gender',
        'permanent_address',
        'current_address',
        'aadhar_number',
        'phone',
        'image',
        'salary',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'subject' => 'json',
    ];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
