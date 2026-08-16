<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'posts';

    protected $fillable = [
        'autor',
        'type',
        'title',
        'content',
        'slug',
        'tags',
        'views',
        'readingTime',
        'metaDescription',
        'excerpt',
        'category',
        'cat_pai',
        'comments',
        'status',
        'highlight',
        'menu',
        'thumb_caption',
        'publish_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'views' => 'integer',
        'readingTime' => 'integer',
        'comments' => 'boolean',
        'status' => 'boolean',
        'highlight' => 'boolean',
        'menu' => 'boolean',
        'publish_at' => 'date',
    ];

    /**
     * Scopes
     */
    public function scopePostson($query)
    {
        return $query->where('status', 1);
    }

    public function scopePostsoff($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Relacionamentos
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'autor', 'id');
    }

    public function categoriaObject()
    {
        return $this->hasOne(CatPost::class, 'id', 'category');
    }

    public function userObject()
    {
        return $this->hasOne(User::class, 'id', 'autor');
    }

    public function images()
    {
        return $this->hasMany(PostGb::class, 'post', 'id')
            ->orderBy('order_img', 'asc')
            ->orderBy('id', 'asc');
    }

    public function countimages()
    {
        return $this->hasMany(PostGb::class, 'post', 'id')->count();
    }

    /**
     * Accerssors and Mutators
     */
    public function getContentWebAttribute()
    {
        return Str::words($this->content, '20', ' ...');
    }

    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if (! $cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if (empty($cover['path']) || ! Storage::disk()->exists($cover['path'])) {
            return url(asset('theme/images/image.jpg'));
        }

        // return Storage::url(Cropper::thumb($cover['path'], 720, 480));
        return Storage::url($cover['path']);
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if (! $cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if (empty($cover['path']) || ! Storage::disk()->exists($cover['path'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }

    public function setPublishAtAttribute($value)
    {
        $this->attributes['publish_at'] = (! empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setSlug()
    {
        if (! empty($this->title)) {
            $post = Post::where('title', $this->title)->first();
            if (! empty($post) && $post->id != $this->id) {
                $this->attributes['slug'] = Str::slug($this->title).'-'.$this->id;
            } else {
                $this->attributes['slug'] = Str::slug($this->title);
            }
            $this->save();
        }
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        [$day, $month, $year] = explode('/', $param);

        return (new \DateTime($year.'-'.$month.'-'.$day))->format('Y-m-d');
    }
}
