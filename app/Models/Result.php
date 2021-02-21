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
        'total_marks',
        'percentage',
        'sgpa',
        'cgpa',
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
    ];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
