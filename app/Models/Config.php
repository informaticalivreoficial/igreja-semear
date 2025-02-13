<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

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
        'ie',
        'domain',
        'subdomain',
        'template',

        //Imagens
        'logo',
        'logo_admin',        
        'logo_footer',
        'favicon',        
        'metaimg',
        'imgheader',
        'watermark',

        //contact 
        'phone',
        'cell_phone',
        'whatsapp',
        'skype',
        'telegram',
        'email',
        'additional_email',
         
        //Address      
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',

        //Social
        'facebook', 'twitter', 'instagram', 'youtube', 'linkedin',

        //Seo
        'information', 
        'privacy_policy',
        'maps_google', 
        'metatags', 'rss', 
        'rss_data', 
        'sitemap', 
        'sitemap_data',
        'analytics_id'
    ];

    /**
     * Accerssors and Mutators
     */
    
    public function getmetaimg()
    {
        if(empty($this->metaimg) || !Storage::disk()->exists($this->metaimg)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->metaimg);
    }
    
    public function getlogomarca()
    {
        if(empty($this->logomarca) || !Storage::disk()->exists($this->logomarca)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->logomarca);
    }
    
    public function getlogoadmin()
    {
        if(empty($this->logomarca_admin) || !Storage::disk()->exists($this->logomarca_admin)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->logomarca_admin);
    }
    
    public function getfaveicon()
    {
        if(empty($this->favicon) || !Storage::disk()->exists($this->favicon)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->favicon);
    }
    
    public function getmarcadagua()
    {
        if(empty($this->marcadagua) || !Storage::disk()->exists($this->marcadagua)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->marcadagua);
    }
    
    public function gettopodosite()
    {
        if(empty($this->imgheader) || !Storage::disk()->exists($this->imgheader)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this->imgheader);
    }
    
    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCepAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }
    
    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    //Formata o celular para exibir
    public function getWhatsappAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }

    
    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
