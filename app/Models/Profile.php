<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'facebook',
        'phone',
        'twitter',
        'address',
        'image',
        'slug_url',
    ];
    protected $dates = ['deleted_at'];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
