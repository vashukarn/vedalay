<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'title' => "json", 
        'description' => "json"
    ];
    public function blogs()
    {
        return $this->belongsToMany(Blog::class)->withTimestamps();
    }

    public function scopeStatus($query)
    {
        return $query->where('publish_status', '1');
    }
}
