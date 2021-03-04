<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'last_marksheet',
        'last_schoolname',
        'last_level',
        'last_marks',
        'transfer_certificate',
        'character_certificate',
        'migration_certificate',
        'last_state',
        'last_city',
        'user_id',
        'student_id',
    ];
    protected $dates = ['deleted_at'];
    public function get_student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'student_id');
    }
}
