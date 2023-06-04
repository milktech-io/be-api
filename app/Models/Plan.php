<?php

namespace App\Models;

use App\Traits\StoreImage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory,Uuid,SoftDeletes,StoreImage;

    public $incrementing = false;

    protected $keyType = 'uuid';

    public $blockchainPrefix = '01';

    protected $hidden = ['deleted_at', 'created_at', 'updated_at', 'created_by'];

    protected $casts = [
        'id' => 'string',
    ];

    protected $storageRoute = 'plan';

    protected $appends = ['image'];

    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'image_url',
        'currency',
        'automatically_ends',
        'plus_comission',
        'generate_roi',
        'interest',
        'created_by',
        'product_id',
        'active',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
