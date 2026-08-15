<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'slides';

    protected $fillable = [
        'title',
        'subtitle',
        'button_label',
        'image',
        'content',
        'link',
        'target',
        'slug',
        'category',
        'expires_at',
        'is_active',
        'show_title',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'target' => 'boolean',
        'is_active' => 'boolean',
        'show_title' => 'boolean',
        'expires_at' => 'date',
    ];

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Accessors
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return '';
        }

        return Storage::disk('public')->url($this->image);
    }

    public function imageUrl()
    {
        if (empty($this->image) || ! Storage::disk('public')->exists($this->image)) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::disk('public')->url($this->image);
    }

    public function setExpiresAtAttribute($value)
    {
        $this->attributes['expires_at'] = (! empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setSlug()
    {
        if (! empty($this->title)) {
            $slide = Slide::where('title', $this->title)->first();
            if (! empty($slide) && $slide->id != $this->id) {
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
