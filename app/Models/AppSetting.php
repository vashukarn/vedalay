<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'address',
        'current_session',
        'email',
        'phone',
        'is_favicon',
        'twitter',
        'razorpay_payment',
        'marks_scheme',
        'instagram',
        'linkedin',
        'skype',
        'facebook',
        'youtube',
        'is_meta',
        'meta',
        'logo',
        'logo_light',
        'favicon',
        'og_image',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'address' => 'json',
        'email' => 'json',
        'phone' => 'json',
        'meta' => 'json',
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
