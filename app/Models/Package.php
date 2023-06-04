<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'user_id',
        'plan_id',
        'date',
        'end_date',
        'plus_comission',
        'generate_roi',
        'months',
        'price',
        'currency',
        'interest',
        'automatically_ends',
        'created_at',
        'updated_at',
        'purchase_id',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 'completado');
    }

    public function scopeReward($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 'completado');
            $query->orWhere('status', 'activo');
        });
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function last_balance()
    {
        return $this->hasOne(Balance::class)->where('last', 1);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
