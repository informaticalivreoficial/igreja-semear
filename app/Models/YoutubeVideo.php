<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class YoutubeVideo extends Model
{
    use HasFactory;

    protected $table = 'youtube_videos';

    public const TYPE_CULTO = 'culto';

    public const TYPE_PREGACAO = 'pregacao';

    protected $fillable = [
        'title',
        'description',
        'youtube_id',
        'type',
        'category',
        'is_live',
        'scheduled_at',
        'status',
        'cover',
        'publish_at',
        'order',
        'created_by',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'scheduled_at' => 'datetime',
        'status' => 'boolean',
        'publish_at' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function thumbnail()
    {
        if (! empty($this->cover) && Storage::disk('public')->exists($this->cover)) {
            return Storage::url($this->cover);
        }

        return 'https://img.youtube.com/vi/'.$this->youtube_id.'/hqdefault.jpg';
    }

    public function embedUrl()
    {
        return 'https://www.youtube.com/embed/'.$this->youtube_id;
    }

    public function watchUrl()
    {
        return 'https://www.youtube.com/watch?v='.$this->youtube_id;
    }
}