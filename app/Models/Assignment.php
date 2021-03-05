<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'deadline',
        'references',
        'description',
        'subject_id',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'references' => 'json',
    ];
    public function get_subject()
    {
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
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
