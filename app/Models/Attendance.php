<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'students',
        'subject_id',
        'holiday',
        'holiday_reason',
        'level_id',
        'created_by',
        'updated_by'
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'students' => 'json',
    ];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    public function get_level()
    {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }
    public function get_subject()
    {
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }
}
