<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'unique',
        'tuition_fee',
        'exam_fee',
        'transport_fee',
        'stationery_fee',
        'sports_fee',
        'club_fee',
        'hostel_fee',
        'laundry_fee',
        'education_tax',
        'eca_fee',
        'late_fine',
        'extra_fee',
        'total_amount',
        'rollback',
        'level_id',
        'student_id',
        'added_by',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'fees' => 'json',
    ];
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
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
}
