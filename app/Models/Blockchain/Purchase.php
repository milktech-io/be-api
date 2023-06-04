<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $connection = 'blockchain';

    protected $table = 'purchase';

    protected $casts = [
        'payload' => 'array',
    ];
}
