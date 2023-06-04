<?php

namespace App\Models;

use App\Models\Static\StaticProducts;
use App\Traits\StoreImage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,Uuid,SoftDeletes,StoreImage;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'more_content',
        'description',
        'short_description',
        'sold',
        'model',
        'model_id',
        'category_id',
        'variant',
        'features',
        'multiplier',
        'metadata',
        'static',
    ];

    protected $cast = [
        'features' => 'json',
        'metadata' => 'array',
    ];

    protected $hidden = ['image_url', 'created_at', 'updated_at', 'deleted_at'];

    protected $with = ['average', 'category'];

    protected $storageRoute = 'products';

    protected $appends = ['stock'];

    protected $casts = [
        'id' => 'string',
    ];

    public function reviewsTotal()
    {
        return $this->hasOne(Review::class)->count();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('hidden', 0)->orderBy('created_at', 'desc')->take(5);
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    public function getstockAttribute()
    {
        try {
            return  (new $this->variant)->where('product_id', $this->id)->sum('stock');
        } catch (\Exception) {
            return 0;
        }
    }

    public function current_version()
    {
        return $this->hasOne(Version::class)->orderBy('created_at', 'DESC');
    }

    public function gallery()
    {
        return $this->hasMany(Image::class)->where('type', 'gallery');
    }

    public function logo()
    {
        return $this->hasMany(Image::class)->where('type', 'logo');
    }

    public function banner()
    {
        return $this->hasMany(Image::class)->where('type', 'banner');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name', 'slug');
    }

    public function drop()
    {
        $this->unlink('image_url');
        $this->delete();
    }

    public function average()
    {
        return $this->hasOne(Review::class)->selectRaw('AVG(stars) as stars,product_id');
    }

    public function statics()
    {
        return $this->hasMany(StaticProducts::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
