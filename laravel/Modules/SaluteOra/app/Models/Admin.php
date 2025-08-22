<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Modules\SaluteOra\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Admin
 * 
 * NOTA: Il trait HasFactory è stato rimosso perché già incluso nella catena di ereditarietà (BaseUser -> User -> Admin).
 * Dichiararlo qui è ridondante e può causare warning o confusione.
 * Vedi docs/DRY-model-traits.md
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserId($value)
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
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
 * @property \Modules\SaluteOra\States\User\UserState|null $state
 * @property array<array-key, mixed>|null $moderation_data
 * @property string|null $lang
 * @property \Modules\SaluteOra\Enums\UserTypeEnum|null $type
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Illuminate\Support\Carbon|null $password_expires_at
 * @property string|null $uuid
 * @property string|null $full_name
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User> $all_team_users
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
 * @property-read \Modules\SaluteOra\Models\AdminStudio|\Modules\SaluteOra\Models\AdminTeam|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property string|null $dental_problems
 * @property string|null $last_dental_visit
 * @property string|null $pregnancy_certificate
 * @property string|null $isee_certificate
 * @property string|null $identity_document
 * @property string|null $health_card
 * @property string|null $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePregnancyCertificate($value)
 * @property string|null $country_code
 * @property string|null $children_count
 * @property string|null $family_members
 * @property string|null $years_in_italy
 * @property string|null $nationality
 * @property string|null $fiscal_code
 * @property string|null $data_privacy_form
 * @property string|null $doctor_certificate
 * @property array<array-key, mixed>|null $certification
 * @property string|null $last_dental_visit_period
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereYearsInItaly($value)
 * @property string|null $age_range
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
 * @property-read int|null $studios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereAgeRange($value)
 * @mixin IdeHelperAdmin
 * @mixin \Eloquent
 */
class Admin extends User
{
    use HasParent;


    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'phone',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            //'certifications' => 'array',
            //'availability' => 'array',
        ]);
    }

    /**
     * Relazione molti-a-molti con gli studi gestiti dall'admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Studio, $this>
     */
    public function studios(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToManyX(Studio::class);
    }

    /**
     * Relazione con gli appuntamenti supervisionati dall'admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<Appointment, Studio, $this>
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Appointment::class,
            Studio::class,
            'id', // Foreign key on studios table
            'studio_id', // Foreign key on appointments table
            'id', // Local key on admins table
            'id' // Local key on studios table
        );
    }

    /**
     * Relazione con i dottori che lavorano negli studi gestiti dall'admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Doctor, $this>
     */
    public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        // Relazione many-to-many attraverso studios
        return $this->belongsToManyX(Doctor::class, 'admin_studio')
            ->join('doctor_studio', 'studios.id', '=', 'doctor_studio.studio_id');
    }

    /**
     * Relazione con i pazienti che frequentano gli studi gestiti dall'admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Patient, $this>
     */
    public function patients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        // Relazione many-to-many attraverso studios e appointments
        return $this->belongsToManyX(Patient::class, 'admin_studio')
            ->join('appointments', 'studios.id', '=', 'appointments.studio_id')
            ->distinct();
    }

    /**
     * Relazione con i report generati negli studi gestiti dall'admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<Report, Studio, $this>
     */
    public function reports(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Report::class,
            Studio::class,
            'id', // Foreign key su studios table
            'appointment_id', // Foreign key su reports table (attraverso appointment)
            'id', // Local key su admins table
            'id' // Local key su studios table
        )->join('appointments', 'reports.appointment_id', '=', 'appointments.id')
         ->where('appointments.studio_id', '=', 'studios.id');
    }
}
