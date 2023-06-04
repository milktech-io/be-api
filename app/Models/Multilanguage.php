<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multilanguage extends Model
{
    use HasFactory,Uuid,SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = ['name_long', 'name_short', 'url'];
}
