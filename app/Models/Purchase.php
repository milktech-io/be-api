<?php

namespace App\Models;

use App\Models\Chaincrop\Token as TokenChaincrop;
use App\Models\Newland\Token;
use App\Models\Static\StaticPackage;
use App\Traits\Uuid;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $hidden = ['deleted_at', 'updated_at'];

    protected $with = ['transaction'];

    protected $casts = [
        'id' => 'string',
        'detail' => 'array',
        'items' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'product_id',
        'category_id',
        'variant_id',
        'price',
        'currency',
        'detail',
        'sold',
        'total',
        'latitude',
        'longitude',
        'free',
        'status',
        'purchased_by',
        'transaction_id',
        'currency_price',
        'created_at',
        'updated_at',
        'old_id',
    ];

    public function variant()
    {
        return $this->belongsTo($this->detail['model'], 'variant_id');
    }

    public function scopeVariants($query)
    {
        $query->with(
            'multiplier',
            'newland',
            'chaincrop',
            'static_products'
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->select('id', 'transaction_hash', 'transaction_index');
    }

    public function myReview()
    {
        return $this->hasMany(Review::class)->where('user_id', Auth::user()->id);
    }

    public function static_products()
    {
        return $this->hasMany(StaticPackage::class);
    }

    public function multiplier()
    {
        return  $this->hasOne(Package::class);
    }

    public function newland()
    {
        return  $this->hasMany(Token::class);
    }

    public function chaincrop()
    {
        return $this->hasMany(TokenChaincrop::class);
    }

    public function comissions()
    {
        return $this->hasMany(BondPackage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
