<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

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
        // Address
        'postcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
        // Contact
        'cell_phone', 'whatsapp', 'email', 'additional_email',
        // Social
        'facebook', 'instagram', 'linkedin',
        'status',
        'information',
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
        'birthday' => 'date',
        'baptism' => 'boolean',
        'baptism_date' => 'date',
        'status' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function ministries(): BelongsToMany
    {
        return $this->belongsToMany(Ministry::class, 'ministry_member')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    public function isPastor(): bool
    {
        return $this->hasRole(['super admin', 'admin', 'pastor']);
    }

    public function isLider(): bool
    {
        return $this->hasRole(['super admin', 'admin', 'pastor', 'lider']);
    }

    /**
     * Regras de papel (spatie/permission)
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['super admin', 'admin']);
    }

    public function isEditor(): bool
    {
        return $this->hasRole(['super admin', 'admin', 'editor']);
    }

    public function isMember(): bool
    {
        return $this->hasRole('member');
    }

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
     * Mutators
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = (! empty($value) ? $this->clearField($value) : null);
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = (! empty($value) ? $this->clearField($value) : null);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = (! empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setBaptismDateAttribute($value)
    {
        $this->attributes['baptism_date'] = (! empty($value) ? $this->convertStringToDate($value) : null);
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        [$day, $month, $year] = explode('/', $param);

        return (new \DateTime($year.'-'.$month.'-'.$day))->format('Y-m-d');
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
