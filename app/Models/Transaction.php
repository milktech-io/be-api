<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,Uuid,SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $casts = [
        'id' => 'string',
        'metadata' => 'array',
    ];

    protected $hidden = ['deleted_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'requested_user_id',
        'quantity',
        'currency',
        'transaction_hash',
        'transaction_index',
        'metadata',
    ];

}
