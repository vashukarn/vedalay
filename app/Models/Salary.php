<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'month',
        'salary',
        'rollback',
        'unique',
        'teacher_id',
        'added_by',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'salary' => 'json',
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
        return $this->hasOne('App\Models\User', 'id', 'teacher_id');
    }
}
