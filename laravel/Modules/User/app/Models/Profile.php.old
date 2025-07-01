<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Contracts\UserContract;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Models\Pivots\DeviceProfile;
use Modules\User\Models\Pivots\ProfileTeam;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\SchemalessAttributes\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * User Profile Model
 *
 * Represents a user profile with relationships to devices, teams, and roles.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $bio
 * @property string|null $avatar
 * @property string|null $timezone
 * @property string|null $locale
 * @property array $preferences
 * @property string $status
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra
 * @property-read string $avatar
 * @property-read ProfileContract|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $deviceUsers
 * @property-read int|null $device_users_count
 * @property-read \Modules\User\Models\ProfileTeam|\Modules\User\Models\DeviceProfile|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read string|null $first_name
 * @property-read string|null $full_name
 * @property-read string|null $last_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $mobileDeviceUsers
 * @property-read int|null $mobile_device_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $mobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read ProfileContract|null $updater
 * @property-read UserContract|null $user
 * @property-read string|null $user_name
 * @method static \Modules\User\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Profile extends BaseProfile implements HasMedia
{
    use HasRoles;
    use InteractsWithMedia;
    use HasSchemalessAttributes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'phone',
        'bio',
        'avatar',
        'timezone',
        'locale',
        'status',
        'extra',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
        'extra' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'full_name',
        'display_name',
        'initials',
        'avatar_url',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var list<string>
     */
    protected $with = [
        'media',
    ];

    /**
     * Restituisce il nome completo dell'utente.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Restituisce il display name dell'utente.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->user_name ?: $this->full_name;
    }

    /**
     * Restituisce le iniziali dell'utente.
     *
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr((string) $this->first_name, 0, 1) .
            substr((string) $this->last_name, 0, 1)
        );
    }

    /**
     * Restituisce l'URL dell'avatar dell'utente.
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar') ?: null;
    }

    /**
     * Relazione con l'utente proprietario del profilo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Relazione con i dispositivi associati al profilo.
     *
     * @return HasManyThrough
     */
    public function devices(): HasManyThrough
    {
        return $this->hasManyThrough(
            Device::class,
            DeviceUser::class,
            'profile_id',
            'id',
            'id',
            'device_id'
        );
    }

    /**
     * Relazione con i device user associati al profilo.
     *
     * @return HasMany
     */
    public function deviceUsers(): HasMany
    {
        return $this->hasMany(DeviceUser::class);
    }

    /**
     * Relazione con il creatore del profilo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(static::class, 'created_by');
    }

    /**
     * Relazione con l'ultimo utente che ha aggiornato il profilo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(static::class, 'updated_by');
    }

    /**
     * Relazione con i team associati al profilo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'profile_team')
            ->using(ProfileTeam::class)
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    /**
     * Crea una nuova factory per il modello.
     *
     * @return ProfileFactory
     */
    protected static function newFactory(): ProfileFactory
    {
        return ProfileFactory::new();
    }
}
