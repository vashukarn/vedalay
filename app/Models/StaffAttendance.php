<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffAttendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'attendance',
        'created_by',
        'updated_by'
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'attendance' => 'json',
    ];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    public function get_user()
    {
        return $this->hasOne('App\Models\Subject', 'id', 'user_id');
    }
}
