<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'payment_id',
        'type',
        'amount',
        'user_id',
    ];
    protected $dates = ['deleted_at'];
    public function payer()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
