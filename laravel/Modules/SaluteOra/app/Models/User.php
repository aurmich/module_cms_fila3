<?php
declare(strict_types=1);
namespace Modules\SaluteOra\Models;


use Modules\User\Models\BaseUser;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;

use Spatie\Permission\Traits\HasRoles;
use Modules\Gdpr\Models\Traits\HasGdpr;
use Illuminate\Notifications\Notifiable;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Active;
use Spatie\ModelStates\HasStatesContract;
use Modules\SaluteOra\Enums\UserStateEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\States\User\Rejected;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\States\User\UserState;
use Modules\SaluteOra\States\User\IntegrationRequested;

/**
 * Modello User per il modulo Patient.
 * 
 * Questo modello estende BaseUser e implementa Single Table Inheritance
 * per gestire i tipi di utente (doctor, patient).
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property UserTypeEnum $type
 * @property UserState $state
 * @property string|null $first_name
 * @property string|null $last_name
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $city
 * @property string|null $phone
 * @property string|null $lang
 * @property int|null $current_team_id
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Carbon\Carbon|null $password_expires_at
 * @property int|null $studio_id
 * @property string|null $continuation_token
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @see \Modules\User\Models\BaseUser
 * @see \Modules\SaluteOra\Models\Doctor
 * @see \Modules\SaluteOra\Models\Patient
 * @property string|null $registration_number
 * @property string|null $status
 * @property array<array-key, mixed>|null $certifications
 * @property string|null $remember_token
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property array<array-key, mixed>|null $moderation_data
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
 * @property-read \Modules\SaluteOra\Models\StudioUser|\Modules\SaluteOra\Models\TeamUser|\Modules\User\Models\DeviceUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @property string|null $dental_problems
 * @property string|null $last_dental_visit
 * @property string|null $pregnancy_certificate
 * @property string|null $isee_certificate
 * @property string|null $identity_document
 * @property string|null $health_card
 * @property string|null $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePregnancyCertificate($value)
 * @mixin \Eloquent
 */
class User extends BaseUser implements HasMedia,HasStatesContract 
{
    use LogsActivity;
    use HasStates;
    use HasGdpr;
    use InteractsWithMedia;

    /** @var string  */
    //protected $connection = 'user';
    protected $connection = 'salute_ora';


    /**
     * Mappatura dei tipi di utente con le relative classi
     * Utilizziamo l'enum UserTypeEnum per una gestione tipizzata e sicura
     */
    protected $childTypes = [
        /*
        UserTypeEnum::ADMIN->value => Admin::class,
        UserTypeEnum::DOCTOR->value => Doctor::class,
        UserTypeEnum::PATIENT->value => Patient::class,
        */
        'admin' => Admin::class,
        'doctor' => Doctor::class,
        'patient' => Patient::class,
    ];

    /** @var array<string, mixed>  */
    protected $attributes = [
        //'state' => Pending::class,
        //'state' => 'pending',
        'is_otp'=>false,
        'is_active'=>true,
        'type' => 'patient',  // Valore di default secondo la best practice dell'enum
    ];


    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'state',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'phone',
        'lang',
        'current_team_id',
        //'is_active',
        'is_otp',
        'password_expires_at',
        //'studio_id',
        //'continuation_token',
        'certifications'
    ];

    

    /**
     * Cast custom per il campo type:
     * - Va dichiarato solo nel modello User del modulo SaluteOra, mai nella base User generica.
     * - Motivazione: evitare di sporcare il modulo User condiviso tra più progetti.
     * - Filosofia: ogni modulo è autonomo, nessun lock-in, rispetto della modularità.
     * - Politica: type safety, DRY, serenità del codice, nessun errore di cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserTypeEnum::class, // Sintassi corretta per Laravel 12
            'state' => UserState::class,
            'certifications' => 'array',
            'certification' => 'array',  // ESSENZIALE: Evita "foreach() argument must be of type array|object, string given"
            'moderation_data' => 'array',
        ]);

        
    }

   

    /**
     * Configurazione per il logging delle attività.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'type', 'state'])
            ->logOnlyDirty();
    }

    /**
     * Verifica se l'utente ha dati validi per la transizione di stato.
     *
     * @return bool
     */
    /**
     * Verifica se l'utente ha dati validi per la transizione di stato.
     *
     * @return bool
     */
    public function hasValidData(): bool
    {
        return !empty($this->name) && !empty($this->email);
    }

    /**
     * Transizione allo stato attivo.
     *
     * @return void
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function activate(): void
    {
        $this->state->transitionTo(Active::class);
    }

    /**
     * Transizione allo stato sospeso.
     *
     * @return void
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function suspend(): void
    {
        $this->state->transitionTo(Suspended::class);
    }

    /**
     * Transizione allo stato rifiutato.
     *
     * @return void
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function reject(): void
    {
        $this->state->transitionTo(Rejected::class);
    }

    /**
     * Transizione allo stato di richiesta integrazione.
     *
     * @return void
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function requestIntegration(): void
    {
        $this->state->transitionTo(IntegrationRequested::class);
    }

    /**
     * Verifica se l'utente è attivo.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->state->equals(Active::class);
    }

    /**
     * Verifica se l'utente è in attesa.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->state->equals(Pending::class);
    }

    /**
     * Verifica se l'utente è sospeso.
     *
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->state->equals(Suspended::class);
    }

    /**
     * Verifica se l'utente è rifiutato.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->state->equals(Rejected::class);
    }

    /**
     * Verifica se è richiesta un'integrazione.
     *
     * @return bool
     */
    public function isIntegrationRequested(): bool
    {
        return $this->state->equals(IntegrationRequested::class);
    }



    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->type === UserTypeEnum::ADMIN;
    }

    /**
     * Determine if the user is a doctor.
     */
    public function isDoctor(): bool
    {
        return $this->type === UserTypeEnum::DOCTOR;
    }

    /**
     * Determine if the user is a patient.
     */
    public function isPatient(): bool
    {
        return $this->type === UserTypeEnum::PATIENT;
    }

    /**
     * Scope per query: solo admin.
     */
    public function scopeAdmins(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('type', UserTypeEnum::ADMIN->value);
    }

    /**
     * Scope per query: solo dottori.
     */
    public function scopeDoctors(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('type', UserTypeEnum::DOCTOR->value);
    }

    /**
     * Scope per query: solo pazienti.
     */
    public function scopePatients(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('type', UserTypeEnum::PATIENT->value);
    }
}
