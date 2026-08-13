<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostGb extends Model
{
    use HasFactory;

    protected $table = 'post_gb';

    protected $fillable = [
        'order_img',
        'post',
        'path',
        'cover',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'order_img' => 'integer',
        'cover' => 'boolean',
    ];

    /**
     * Accessors
     */
    public function getUrlCroppedAttribute()
    {
        return Storage::url($this->path);
    }

    public function getUrlImageAttribute()
    {
        return Storage::url($this->path);
    }
}
