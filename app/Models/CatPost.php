<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatPost extends Model
{
    use HasFactory;

    protected $table = 'cat_post';

    protected $fillable = [
        'title',
        'type',
        'content',
        'slug',
        'tags',
        'views',
        'status',
        'id_pai',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'views' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Relacionamentos
     */
    public function children()
    {
        return $this->hasMany(CatPost::class, 'id_pai', 'id');
    }

    public function countposts()
    {
        return $this->hasMany(Post::class, 'category', 'id')->count();
    }

    public function setSlug()
    {
        if (! empty($this->title)) {
            $categoria = CatPost::where('title', $this->title)->first();
            if (! empty($categoria) && $categoria->id != $this->id) {
                $this->attributes['slug'] = Str::slug($this->title).'-'.$this->id;
            } else {
                $this->attributes['slug'] = Str::slug($this->title);
            }
            $this->save();
        }
    }
}
