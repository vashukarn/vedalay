<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'quantity',
        'act',
        'total_price',
        'item_id',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    public function item()
    {
        return $this->hasOne('App\Models\InventoryItem', 'id', 'item_id');
    }
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
