<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'rollback',
        'month',
        'monthly_salary',
        'tada',
        'extra_class',
        'incentive',
        'transport_charges',
        'leave_charges',
        'bonus',
        'advance_salary',
        'total_amount',
        'added_by',
        'user_id',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
