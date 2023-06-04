<?php

namespace App\Models;

use App\Traits\StoreImage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory,Uuid,SoftDeletes,StoreImage;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'type', 'title', 'product_id',
    ];

    protected $hidden = ['image_url', 'created_at', 'updated_at', 'deleted_at', 'product_id', 'type'];

    protected $appends = ['image'];

    protected $storageRoute = 'images';

    protected $casts = [
        'id' => 'string',
    ];
}
