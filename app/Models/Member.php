<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'family_id', 'family_role',
        'name', 'gender', 'cpf', 'rg', 'rg_expedition', 'birthday', 'naturalness',
        'civil_status', 'avatar', 'baptism', 'baptism_date',
        'postcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
        'cell_phone', 'whatsapp', 'email', 'additional_email',
        'facebook', 'instagram', 'linkedin',
        'status', 'information',
    ];

    protected $casts = [
        'birthday' => 'date',
        'baptism' => 'boolean',
        'baptism_date' => 'date',
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function prayerRequests(): HasMany
    {
        return $this->hasMany(PrayerRequest::class);
    }

    public function getMinistriesAttribute()
    {
        return $this->user?->ministries;
    }

    public function getFamilyRoleLabelAttribute(): string
    {
        return match ($this->family_role) {
            'chefe' => 'Chefe da família',
            'conjuge' => 'Cônjuge',
            'filho' => 'Filho(a)',
            default => 'Membro',
        };
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

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
