<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Uuid, SoftDeletes, Notifiable, HasFactory, Notifiable,hasRoles;

    public $incrementing = false;

    protected $keyType = 'uuid';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_id',
        'email_verified_at',
        'is_active',
        'sponsor_id',
        'old_id',
        'metadata',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'login_attemps',
        'email_verified_at',
        'token',
        'token_expire_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'metadata' => 'array',
    ];
    
    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function gettokenAttribute()
    {
        return $this->tokens->where('revoked', 0)->first();
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function saveToken($token)
    {
        $jwt = Token::decode($token);

        $tokenData = [
            'expires_at' => date('Y-m-d H:i:s', $jwt['exp']),
            'jti' => $jwt['jti'],
            'revoked' => 0,
        ];

        $this->tokens()->update([
            'revoked' => 1,
            'user_id' => $this->id,
        ]);
        $this->tokens()->create($tokenData);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id')->select('id', 'name');
    }

    public function dropUser()
    {
        $DELETED = '_DELETED_';
        $this->is_active = 0;
        $this->email = $this->email.$DELETED.uniqid();
        $this->username = $this->username.$DELETED.uniqid();
        $this->deleted_at = now();
        $this->profile->email = $this->email.$DELETED.uniqid();
        $this->profile->deleted_at = now();
        $this->profile->save();
        $this->save();
    }

    public function toJWTarray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'sponsor_id' => $this->sponsor_id,
            'roles' => $this->roles,
            'profile' => [
                'id' => $this->profile->id,
                'name' => $this->profile->name,
                'lastname' => $this->profile->lastname,
                'language' => $this->profile->language,
            ],
        ];
    }
}
