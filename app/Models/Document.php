<?php

namespace App\Models;

use App\Traits\StoreDocument;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory,Uuid,StoreDocument;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name', 'extension', 'rangue_id',
    ];

    protected $hidden = ['file_url', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['file'];

    protected $storageRoute = 'documents';

    protected $casts = [
        'id' => 'string',
    ];

    protected $with = ['rangue'];

    public function rangue()
    {
        return $this->belongsTo(Rangue::class)->select('id', 'name', 'number');
    }
}
