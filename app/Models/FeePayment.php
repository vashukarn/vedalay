<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeePayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
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
        'payment_method',
        'upi_type',
        'bank_ifsc',
        'bank_accountno',
        'transfer_phone',
        'transfer_date',
        'card_type',
        'remarks',
        'student_id',
        'created_by',
        'updated_by',
        'session',
        'level_id',
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
}
