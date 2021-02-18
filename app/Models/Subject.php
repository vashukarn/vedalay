<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'level_id',
        'title',
        'publish_status',
        'type',
        'value',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    public function get_level()
    {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }
}
