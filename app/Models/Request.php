<?php

namespace App\Models;

use App\Traits\StoreImage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Request extends Model
{
    use HasFactory,SoftDeletes,Uuid,StoreImage;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'user_id', 'action', 'requested_by', 'password',
    ];

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}
