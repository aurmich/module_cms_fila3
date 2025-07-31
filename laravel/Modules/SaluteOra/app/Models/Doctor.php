<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Modules\Geo\Models\Address;
use Spatie\MediaLibrary\HasMedia;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserStateEnum;
use Modules\SaluteOra\Models\DoctorStudio;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\SaluteOra\States\User\UserState;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Doctor model for the SaluteOra module.
 * 
 * Extends the User model to provide doctor-specific functionality.
 
 */
class Doctor extends User implements HasMedia
{
    use HasParent;
    use InteractsWithMedia;

   
    /** @var list<string>     */
    protected $fillable = [
        //'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        //'specialization',
        'certifications', // Mantenuto per retrocompatibilità
        'certification', // 
        'doctor_certificate',
        //'availability',
        'status',
        'country_code',
        'data_privacy_form',
    ];

    /** @var list<string>     */
    protected $appends = [
        //'health_card',
        //'identity_document',
        
        //'pregnancy_certificate',
        // 'certifications', // Gestito da getter personalizzato
        //'studio',
        //'studio::description',
        //'studio:address',
    ];

    /** @return list<string>     */
    public static function getAttachments():array{
        return  [
            //'certification', // Gestito come allegato singolo
            'doctor_certificate',
            'data_privacy_form',
        ];
    }

    /** @var list<string>     */
    protected $with = [
        'studio',
        'studio.address',
    ];

   

    public function getDataDefaults(): array
    {
        return [
            //'certification'=> null,
            'studio'=>[
                'description' => null,
                'address'=>[
                    'administrative_area_level_1' => null,
                    'administrative_area_level_2' => null,
                    'administrative_area_level_3' => null,
                    'locality' => null,
                    'postal_code' => null,
                ],
            ],
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            //'certification' => 'array',  // OBBLIGATORIO: campo in $attachments DEVE essere array per FileUpload
            'certifications' => 'array', // Per retrocompatibilità
        ]);
    }

    
    /**
     * Relazione molti-a-molti con gli studi in cui il dottore lavora.
     *
     * IMPORTANTE: Questa è una relazione cross-database, dove:
     * - Doctor risiede nel database 'user'
     * - Studio risiede nel database 'salute_ora'
     * - doctor_studio (pivot) risiede nel database 'saluteora_data'
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function studios(): BelongsToMany
    {
        return $this->belongsToManyX(Studio::class);
    }



    public function studio(): MorphOne
    {
        return $this->morphOne(Studio::class, 'model');
    }

    public function address(): MorphOne{
        return $this->morphOne(Address::class, 'model');
    }
    // Implementazione della relazione BelongsToMany con Studio completata

/*
    public function getCertificationsAttribute()
    {
        // Prima controlla se c'è un valore nel database (campo array)
        if ($this->attributes['certifications'] ?? null) {
            return json_decode($this->attributes['certifications'], true);
        }
        
        // Altrimenti usa Media Library
        return $this->getFirstMediaPath('certifications');
    }
    
    public function setCertificationsAttribute($value)
    {
        // Se è un array di file paths (da FileUpload), salva come JSON
        if (is_array($value)) {
            $this->attributes['certifications'] = json_encode($value);
        } else {
            $this->attributes['certifications'] = $value;
        }
    }
        */

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }


}
