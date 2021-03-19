<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'marks',
        'backlogs',
        'gper',
        'total_marks',
        'percentage',
        'session',
        'marks_obtained',
        'grade',
        'withheld_reason',
        'sgpa',
        'status',
        'publish_status',
        'student_id',
        'level_id',
        'created_by',
        'updated_by'
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'marks' => 'json',
        'backlogs' => 'json',
    ];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function student()
    {
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
    public function get_level()
    {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }
    public function get_exam()
    {
        return $this->hasOne('App\Models\Exam', 'id', 'exam_id');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
