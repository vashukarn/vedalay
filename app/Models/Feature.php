<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'short_title',
        'publish_status',
        'icon',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
}
