<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Config extends Model
{
    use HasFactory;

    protected $table = 'config';

    protected $fillable = [
        'status',
        'init_date',
        'app_name',
        'social_name',
        'alias_name',
        'slug',
        'cnpj',
        'domain',
        'subdomain',
        'template',

        // Imagens
        'logo',
        'logo_admin',
        'logo_footer',
        'favicon',
        'metaimg',
        'imgheader',
        'watermark',

        // contact
        'phone',
        'cell_phone',
        'whatsapp',
        'email',
        'additional_email',

        // Address
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',

        // Social
        'facebook', 'twitter', 'instagram', 'youtube', 'linkedin',

        // Seo
        'information',
        'privacy_policy',
        'maps_google',
        'live_url',
        'metatags', 'rss',
        'rss_data',
        'sitemap',
        'sitemap_data',
        'analytics_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'init_date' => 'date',
        'rss_data' => 'date',
        'sitemap_data' => 'date',
    ];

    /**
     * Mutators
     */
    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (! empty($value) ? $this->clearField($value) : null);
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

    /**
     * Helpers de imagem
     */
    public function getmetaimg()
    {
        if (empty($this->metaimg) || ! Storage::disk()->exists($this->metaimg)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->metaimg);
    }

    public function getlogo()
    {
        if (empty($this->logo) || ! Storage::disk()->exists($this->logo)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->logo);
    }

    public function getlogoadmin()
    {
        if (empty($this->logo_admin) || ! Storage::disk()->exists($this->logo_admin)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->logo_admin);
    }

    public function getfaveicon()
    {
        if (empty($this->favicon) || ! Storage::disk()->exists($this->favicon)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->favicon);
    }

    public function getwatermark()
    {
        if (empty($this->watermark) || ! Storage::disk()->exists($this->watermark)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->watermark);
    }

    public function getheadersite()
    {
        if (empty($this->imgheader) || ! Storage::disk()->exists($this->imgheader)) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->imgheader);
    }
}
