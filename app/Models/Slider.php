<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'sub_title', 'description','image', 'slider_type', 'external_url'
        , 'show_on', 'position', 'publish_status', 'updated_by', 'created_by'
    ];
    protected $casts  = [
        'title' => 'json',
        'sub_title' => 'json',
        'description' => 'json',
    ];
    protected $dates  = ['deleted_at'];
}
