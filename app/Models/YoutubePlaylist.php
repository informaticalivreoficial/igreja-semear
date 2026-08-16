<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class YoutubePlaylist extends Model
{
    use HasFactory;

    protected $table = 'youtube_playlists';

    protected $fillable = [
        'title',
        'description',
        'youtube_id',
        'cover',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function thumbnail()
    {
        if (! empty($this->cover) && Storage::disk('public')->exists($this->cover)) {
            return Storage::url($this->cover);
        }

        return 'https://img.youtube.com/vi/'.$this->youtube_id.'/hqdefault.jpg';
    }

    public function embedUrl()
    {
        return 'https://www.youtube.com/embed/videoseries?list='.$this->youtube_id;
    }

    public function watchUrl()
    {
        return 'https://www.youtube.com/playlist?list='.$this->youtube_id;
    }
}