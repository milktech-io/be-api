<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    use HasFactory;

    protected $connection = 'blockchain';

    protected $table = 'swaps';

    protected $casts = [
        'payload' => 'array',
    ];
}
