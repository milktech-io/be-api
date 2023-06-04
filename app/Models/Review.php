<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory,Uuid,SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'stars', 'title', 'comment', 'user_id', 'product_id', 'purchase_id',
    ];

    protected $hidden = ['hidden', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'string',
    ];

    public function censored()
    {
        return $this->hasOne(Review::class, 'id', 'id')->where('hidden', 1)->select('id');
    }
}
