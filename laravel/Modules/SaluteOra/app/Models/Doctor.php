<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\Address;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\UserState;
use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Doctor model for the SaluteOra module.
 * 
 * Extends the User model to provide doctor-specific functionality.
 *
 * @property string                                                                                                     $id
 * @property string|null                                                                                                $name
 * @property string|null                                                                                                $first_name
 * @property string|null                                                                                                $last_name
 * @property string                                                                                                     $email
 * @property string|null                                                                                                $phone
 * @property string|null                                                                                                $country_code
 * @property string|null                                                                                                $children_count
 * @property string|null                                                                                                $family_members
 * @property string|null                                                                                                $years_in_italy
 * @property string|null                                                                                                $nationality
 * @property Address|null                                                                                               $address
 * @property string|null                                                                                                $city
 * @property string|null                                                                                                $registration_number
 * @property string|null                                                                                                $fiscal_code
 * @property string|null                                                                                                $dental_problems
 * @property string|null                                                                                                $last_dental_visit
 * @property string|null                                                                                                $status
 * @property array<array-key, mixed>|null                                                                               $certifications
 * @property \Illuminate\Support\Carbon|null                                                                            $email_verified_at
 * @property string|null                                                                                                $password
 * @property string|null                                                                                                $remember_token
 * @property int|null                                                                                                   $current_team_id
 * @property string|null                                                                                                $profile_photo_path
 * @property \Illuminate\Support\Carbon|null                                                                            $deleted_at
 * @property string|null                                                                                                $lang
 * @property UserTypeEnum|null                                                                                          $type
 * @property string|null                                                                                                $data_privacy_form
 * @property string|null                                                                                                $doctor_certificate
 * @property array<array-key, mixed>|null                                                                               $certification
 * @property string|null                                                                                                $pregnancy_certificate
 * @property string|null                                                                                                $isee_certificate
 * @property string|null                                                                                                $identity_document
 * @property string|null                                                                                                $health_card
 * @property string|null                                                                                                $date_of_birth
 * @property string|null                                                                                                $gender
 * @property bool|null                                                                                                  $is_active
 * @property bool|null                                                                                                  $is_otp
 * @property \Illuminate\Support\Carbon|null                                                                            $password_expires_at
 * @property \Illuminate\Support\Carbon|null                                                                            $created_at
 * @property \Illuminate\Support\Carbon|null                                                                            $updated_at
 * @property string|null                                                                                                $updated_by
 * @property string|null                                                                                                $created_by
 * @property string|null                                                                                                $deleted_by
 * @property UserState|null                                                                                             $state
 * @property array<array-key, mixed>|null                                                                               $moderation_data
 * @property string|null                                                                                                $uuid
 * @property string|null                                                                                                $full_name
 * @property string|null                                                                                                $certificates
 * @property string|null                                                                                                $last_dental_visit_period
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent>                                $activeConsents
 * @property int|null                                                                                                   $active_consents_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity>                           $activities
 * @property int|null                                                                                                   $activities_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Appointment>                                                 $appointments
 * @property int|null                                                                                                   $appointments_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication>                         $authentications
 * @property int|null                                                                                                   $authentications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client>                                    $clients
 * @property int|null                                                                                                   $clients_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent>                                $consents
 * @property int|null                                                                                                   $consents_count
 * @property \Modules\User\Models\Team|null                                                                             $currentTeam
 * @property \Modules\User\Models\Membership|DoctorStudio|\Modules\User\Models\DeviceUser|null                          $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                 $devices
 * @property int|null                                                                                                   $devices_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User>                                   $all_team_users
 * @property \Modules\User\Models\AuthenticationLog|null                                                                $latestAuthentication
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null                                                                                                   $media_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification>           $notifications
 * @property int|null                                                                                                   $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                   $ownedTeams
 * @property int|null                                                                                                   $owned_teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission>                             $permissions
 * @property int|null                                                                                                   $permissions_count
 * @property Profile|null                                                                                               $profile
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role>                                   $roles
 * @property int|null                                                                                                   $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser>                          $socialiteUsers
 * @property int|null                                                                                                   $socialite_users_count
 * @property Studio|null                                                                                                $studio
 * @property \Illuminate\Database\Eloquent\Collection<int, Studio>                                                      $studios
 * @property int|null                                                                                                   $studios_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership>                             $teamUsers
 * @property int|null                                                                                                   $team_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                   $teams
 * @property int|null                                                                                                   $teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Studio>                                                      $tenants
 * @property int|null                                                                                                   $tenants_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token>                                     $tokens
 * @property int|null                                                                                                   $tokens_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment>                              $treatments
 * @property int|null                                                                                                   $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor doctors()
 * @method static \Modules\SaluteOra\Database\Factories\DoctorFactory  factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePregnancyCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereYearsInItaly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutRole($roles, $guard = null)
 * @property string|null $age_range
 * @property-read array $schedule
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAgeRange($value)
 * @mixin \Eloquent
 */
class Doctor extends User implements HasMedia
{
    use HasParent;
    use InteractsWithMedia;

    /** @var list<string> */
    protected $fillable = [
        // 'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        // 'specialization',
        'certifications', // Mantenuto per retrocompatibilità
        'certification',
        'doctor_certificate',
        // 'availability',
        'status',
        'country_code',
        'data_privacy_form',
    ];

    /** @var list<string> */
    protected $appends = [
        // 'health_card',
        // 'identity_document',

        // 'pregnancy_certificate',
        // 'certifications', // Gestito da getter personalizzato
        // 'studio',
        // 'studio::description',
        // 'studio:address',
    ];

    /** @return list<string>     */
    public static function getAttachments(): array
    {
        return [
            // 'certification', // Gestito come allegato singolo
            'doctor_certificate',
            'data_privacy_form',
        ];
    }

    /** @var list<string> */
    protected $with = [
        'studio',
        'studio.address',
    ];

    public function getDataDefaults(): array
    {
        return [
            // 'certification'=> null,
            'studio' => [
                'description' => null,
                'address' => [
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
            // 'certification' => 'array',  // OBBLIGATORIO: campo in $attachments DEVE essere array per FileUpload
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
     */
    public function studios(): BelongsToMany
    {
        return $this->belongsToManyX(Studio::class);
    }

    public function studio(): MorphOne
    {
        return $this->morphOne(Studio::class, 'model');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }
    // Implementazione della relazione BelongsToMany con Studio completata

    public function getScheduleAttribute(?array $value):array
    {
        $studio = $this->studio;
        $doctor = $this;
        
        if ($studio === null || $studio->id === null) {
            return [];
        }
        
        $pivot=DoctorStudio::firstOrCreate(['user_id'=>$doctor->id,'studio_id'=>$studio->id]);
        $res=$pivot->schedule;
        

        return $res ?? [];
    }

   

    /**
     * Relazione con gli appuntamenti del dottore.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Appointment, $this>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Relazione con i report creati dal dottore.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Report, $this>
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'doctor_id');
    }

    /**
     * Relazione con i pazienti che hanno avuto appuntamenti con questo dottore.
     * Relazione attraverso gli appuntamenti.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Patient, $this>
     */
    public function patients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToManyX(Patient::class, 'appointments', 'doctor_id', 'patient_id')
            ->distinct();
    }
}
