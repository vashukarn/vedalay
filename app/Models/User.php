<?php

namespace App\Models;
use App\Utilities\LogActivity;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        // 'mobile',
        // 'otp',
        // 'otp_created_at',
        'publish_status',
        "email_verified_at"
    ];
    protected $dates  = ['deleted_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRules($act = 'add', $id=null)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|email:rfc,dns|unique:users,email',
            // 'mobile' => 'required|digits:10|numeric|unique:users,mobile,'.$id,
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:1,0',
            'roles' => 'required',
        ];
        if ($act == 'update') {
            $rules['password'] = 'nullable|string|min:8|confirmed';
            $rules['email'] = 'nullable|email';
        }
        return $rules;
    }

    public function regex()
    {
        return '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
    }

    public function sendPasswordResetNotification($token)
    {
        LogActivity::addToLog(request()->email.' Requested for password ResetLink');
        $this->notify(new ResetPasswordNotification($token, request()->email));
    }

    // public function 

}
