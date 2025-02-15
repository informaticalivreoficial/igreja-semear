<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'password', 'remember_token', 'code',
        'gender',
        'cpf',
        'rg',
        'rg_expedition',
        'birthday',
        'naturalness',
        'civil_status',
        'baptism',
        'baptism_date',
        'avatar',  
        //Address      
        'postcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
        //Contact
        'cell_phone', 'whatsapp', 'email', 'additional_email',
        //Social
        'facebook', 'instagram', 'linkedin',  
        //function
        'admin', 'client', 'editor', 'superadmin',
        'status',
        'information'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
   
   
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
     * Accerssors and Mutators
     */

    //Exibe a função do usuário
    public function getFuncao() {
        if($this->admin == 1 && $this->client == 0 && $this->superadmin == 0){
            return 'Administrador';
        }elseif($this->admin == 0 && $this->client == 1 && $this->superadmin == 0){
            return 'Cliente';
        }elseif($this->admin == 0 && $this->client == 0 && $this->editor == 1 && $this->superadmin == 0){
            return 'Editor';
        }elseif($this->admin == 1 && $this->client == 1 && $this->superadmin == 0){
            return 'Administrador/Cliente'; 
        }else{
            return 'Super Administrador'; 
        }
    }
    
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCpfAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCellPhoneAttribute($value)
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

    public function setAdminAttribute($value)
    {
        $this->attributes['admin'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setEditorAttribute($value)
    {
        $this->attributes['editor'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setClientAttribute($value)
    {
        $this->attributes['client'] = ($value === true || $value === 'on' ? 1 : 0);
    }
    
    public function setSuperAdminAttribute($value)
    {
        $this->attributes['superadmin'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setBaptismAttribute($value)
    {
        $this->attributes['baptism'] = ($value === true || $value === 'true' ? 1 : 0);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setBaptismDateAttribute($value)
    {
        $this->attributes['baptism_date'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
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
