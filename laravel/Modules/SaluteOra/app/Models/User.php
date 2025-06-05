<?php
declare(strict_types=1);
namespace Modules\SaluteOra\Models;

use Modules\User\Models\BaseUser;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;

/**
 * Modello User per il modulo Patient.
 *
 * Questo modello estende BaseUser e implementa Single Table Inheritance
 * per gestire i tipi di utente (doctor, patient).
 *
 * @see \Modules\User\Models\BaseUser
 * @see \Modules\SaluteOra\Models\Doctor
 * @see \Modules\SaluteOra\Models\Patient
 */
class User extends BaseUser
{
    use LogsActivity, Notifiable;

    /**
     * La connessione al database.
     *
     * @var string
     */
    protected $connection = 'user';

    /**
     * La colonna che determina il tipo di utente.
     *
     * @var string
     */
    protected $childColumn = 'type';

    /**
     * I tipi di utente supportati.
     *
     * @var array<string, string>
     */
    protected $childTypes = [
        'patient' => Patient::class,
        'doctor' => Doctor::class,
    ];

    /**
     * Gli attributi predefiniti.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'state' => 'pending',
    ];

    /**
     * Gli attributi che devono essere nascosti nelle serializzazioni.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Gli attributi che devono essere convertiti in date.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Gli attributi che possono essere assegnati in massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'state',
        'email_verified_at',
        'last_action_by',
        'last_action_at',
        'last_reason',
    ];

    /**
     * Override dei cast degli attributi.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'certifications' => 'array',
            'moderation_data' => 'array',
        ]);
    }

    /**
     * Implement ownsTeam method to satisfy HasTeamsContract by delegating to ownsTeamTrait.
     *
     * @param \Modules\User\Contracts\TeamContract $team
     * @return bool
     */
    public function ownsTeam(\Modules\User\Contracts\TeamContract $team): bool
    {
        return $this->ownsTeamTrait($team);
    }

    /**
     * Configurazione per il logging delle attività.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['state', 'moderation_data', 'type'])
            ->logOnlyDirty();
    }
}
