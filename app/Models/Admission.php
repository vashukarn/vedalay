<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'last_schoolname',
        'last_level',
        'last_marks',
        'last_state',
        'last_city',
        'transfer_certificate',
        'character_certificate',
        'medical_certificate',
        'undertaking',
        'migration_certificate',
        'last_marksheet',
        'user_id',
        'student_id',
    ];
    protected $dates = ['deleted_at'];
    public function get_student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'student_id');
    }
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
