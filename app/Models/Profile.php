<?php

namespace App\Models;

use App\Traits\StoreImage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes, Uuid,StoreImage;

    public $incrementing = false;

    protected $keyType = 'uuid';

    public $appends = ['image', 'fullName'];

    protected $hidden = ['image_url', 'created_at', 'updated_at', 'deleted_at'];

    protected $storageRoute = 'profile';

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'mobile',
        'profession',
        'image_url',
        'gender',
        'habilities',
        'facebook',
        'instagram',
        'linkedin',
        'twitter',
        'about_me',
        'code_mobile',
        'country',
        'language',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function social()
    {
        return $this->belongsTo(Social::class);
    }

    public function getfullNameAttribute()
    {
        return $this->name.' '.$this->lastname;
    }

    public function sponsor()
    {
        return $this->hasOne(User::class, 'profile_id')
        ->selectRaw("CONCAT(profiles.name,' ',profiles.lastname) as fullName,sponsors.rangue_id, users.profile_id")
        ->join('users as sponsors', 'sponsors.id', 'users.sponsor_id')
        ->join('profiles', 'sponsors.profile_id', 'profiles.id');
    }
}
