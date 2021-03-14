<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'from_date',
        'declined_reason',
        'to_date',
        'image',
        'type',
        'description',
        'days',
        'status',
        'created_by',
        'verified_by',
    ];
    protected $dates = ['deleted_at'];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function verifier()
    {
        return $this->hasOne('App\Models\User', 'id', 'verified_by');
    }
}
