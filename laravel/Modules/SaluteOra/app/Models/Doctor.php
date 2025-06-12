<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\UserStateEnum;
use Parental\HasParent;

/**
 * Doctor model for the SaluteOra module.
 * 
 * Extends the User model to provide doctor-specific functionality.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property UserTypeEnum $type
 * @property UserStateEnum $state
 * @property string|null $continuation_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Studio> $studios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read DoctorRegistrationWorkflow|null $registrationWorkflow
 * @see \Modules\SaluteOra\Models\User
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $registration_number
 * @property string|null $status
 * @property array<array-key, mixed>|null $certifications
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property array<array-key, mixed>|null $moderation_data
 * @property string|null $lang
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Illuminate\Support\Carbon|null $password_expires_at
 * @property string|null $uuid
 * @property string|null $full_name
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $activeConsents
 * @property-read int|null $active_consents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication> $authentications
 * @property-read int|null $authentications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $consents
 * @property-read int|null $consents_count
 * @property-read \Modules\User\Models\Team|null $currentTeam
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Xot\Contracts\UserContract> $all_team_users
 * @property-read \Modules\User\Models\AuthenticationLog|null $latestAuthentication
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser> $socialiteUsers
 * @property-read int|null $socialite_users_count
 * @property-read \Modules\SaluteOra\Models\DoctorTeam|DoctorStudio|null $pivot
 * @property-read int|null $studios_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @property-read \Modules\SaluteOra\Models\DoctorRegistrationWorkflow|null $workflow
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @mixin \Eloquent
 */
class Doctor extends User
{
    use HasParent;

   
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        'specialization',
        'certifications',
        'availability',
        'status',
    ];

    protected $appends = [
        //'health_card',
        //'identity_document',
        //'isee_certificate',
        //'pregnancy_certificate',
        // 'certifications', // Gestito da getter personalizzato
    ];

    public static array $attachments = [
        'certifications',
       
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'certifications' => 'array',
          //  'availability' => 'array',
        ]);
    }

    /**
     * Get the workflow for this doctor's registration.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class, 'doctor_id');
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
}
