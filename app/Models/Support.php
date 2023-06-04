<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['user_id', 'ticket_id', 'status', 'title'];
}
