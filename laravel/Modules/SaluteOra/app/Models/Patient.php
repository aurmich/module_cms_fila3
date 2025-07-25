<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Modules\SaluteOra\Models\User;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Patient
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property \Carbon\Carbon|null $birth_date Alias for date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $fiscal_code
 * @property string|null $pregnancy_status
 * @property int|null $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read \Modules\SaluteOra\Models\PatientIsee|null $isee
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
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
 * @property-read \Modules\SaluteOra\Models\PatientStudio|\Modules\SaluteOra\Models\PatientTeam|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withoutRole($roles, $guard = null)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePregnancyCertificate($value)
 * @mixin \Eloquent
 */
class Patient extends User implements HasMedia
{
    use HasParent;
    use InteractsWithMedia;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'phone',
        'last_dental_visit',
        'dental_problems',

        'health_card',
        'identity_document',
        'isee_certificate',
        'pregnancy_certificate',
        'country_code',
        'nationality',
        'years_in_italy',
        'family_members',
        'children_count',
        'last_dental_visit_period',

        'fiscal_code',

    ];
    protected $appends = [
        //'health_card',
        //'identity_document',
        //'isee_certificate',
        //'pregnancy_certificate',
    ];

    /** @var array<string, mixed>  */
    protected $attributes = [
        //'state' => Pending::class,
        //'state' => 'pending',
        'is_otp'=>false,
        'is_active'=>true,
        'type'=>'patient',
        /*
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
        */
    ];

    public static function getAttachments():array{
        return [
            'health_card',
            //'identity_document',
            'isee_certificate',
            'pregnancy_certificate',
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Registra le conversioni per i media
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Conversione per le anteprime dei documenti
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            //->nonQueued()
            ;

        // Conversione per le immagini dei documenti
        $this
            ->addMediaConversion('document')
            ->fit(Fit::Contain, 800, 800)
            //->nonQueued()
            ;
    }

    /**
     * Registra le collezioni di media
     */
    public function registerMediaCollections(): void
    {
        foreach (self::getAttachments() as $attachment) {
            $this
                ->addMediaCollection($attachment)
                ->singleFile()
                ->useDisk('local');
        }
    }

        /**
     * Verifica se un allegato specifico esiste
     */
    public function hasAttachment(string $type): bool
    {
        return $this->getFirstMedia($type) !== null;
    }

    /**
     * Ottiene l'URL sicuro per visualizzare un allegato
     */
    public function getAttachmentUrl(string $type): ?string
    {
        $media = $this->getFirstMedia($type);
        if (!$media) {
            return null;
        }

        return route('patients.view-pdf', [
            'patient' => $this->id,
            'type' => $type,
            'token' => encrypt([
                'patient_id' => $this->id,
                'type' => $type,
                'user_id' => auth()->id(),
                'expires_at' => now()->addHour()
            ])
        ]);
    }

    /**
     * Conta il numero di allegati presenti
     */
    public function getAttachmentsCount(): int
    {
        $count = 0;
        foreach (self::getAttachments() as $type) {
            if ($this->hasAttachment($type)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Verifica se tutti gli allegati obbligatori sono presenti
     */
    public function hasRequiredAttachments(): bool
    {
        $required = ['health_card', 'identity_document'];
        foreach ($required as $type) {
            if (!$this->hasAttachment($type)) {
                return false;
            }
        }
        return true;
    }


    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class,'patient_id');
    }


    public function canBook(): bool
    {
        if($this->appointments->count()==0){
            return true;
        };
        $res=true;
        foreach($this->appointments as $appointment){
            if(in_array($appointment->state->getName(),[
                'pending',
                'report_pending',
                'report_completed',
                'banned',
                'pro_bono',
                'completed',
                'confirmed',
                'in_progress',
                'refund_pending',
                'refund_completed',
                'refund_to_integrate',
                'refund_accepted',
                'scheduled',
                'rescheduled',
                ])){
                return false;

            }
        }
        return $res;
    }
}