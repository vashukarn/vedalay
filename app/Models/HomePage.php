<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomePage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'topTopics',
        'firstjumbotron',
        'aboutinfo',
        'features',
        'threefeatures',
        'logo',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'topTopics' => 'json',
        'firstjumbotron' => 'json',
        'aboutinfo' => 'json',
        'features' => 'json',
        'threefeatures' => 'json',
        'logos' => 'json',
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
