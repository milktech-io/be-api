<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = 'blockchain';

    protected $table = 'transactions';

    protected $casts = [
        'payload' => 'array',
    ];
}
