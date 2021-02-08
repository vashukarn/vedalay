<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'title',
        'summary',
        'description',
        'category',
        "thumbnail",
        'tags',
        "path",
        "slug",
        "reporter",
        "publish_status",
        "postType",

        'view_count',

        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
        "created_by",
    ];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'title' => "json",
        'summary' => "json",
        'description' => "json",
        'tags' => "json",
        'category' => "json",
    ];
}
