<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'exam_routine',
        'publish_status',
        'session_id',
        'level_id',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'exam_routine' => 'json',
    ];
    public function get_session()
    {
        return $this->hasOne('App\Models\Session', 'id', 'session_id');
    }
    public function get_level()
    {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
