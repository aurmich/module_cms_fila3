<?php
declare(strict_types=1);
namespace Modules\SaluteOra\Models;

use Modules\User\Models\BaseUser;
use Spatie\ModelStates\HasStates;
use Spatie\Activitylog\LogOptions;
use Modules\SaluteOra\Enums\UserType;

use Modules\SaluteOra\States\User\UserState;
use Illuminate\Notifications\Notifiable;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\States\User\Rejected;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\States\User\IntegrationRequested;

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
    use HasStates;

    /** @var string  */
    protected $connection = 'user';


    /** @var array<string, string> */
    protected $childTypes = [
        'patient' => Patient::class,
        'doctor' => Doctor::class,
        'admin' => Admin::class,
    ];

    /** @var array<string, mixed>  */
    protected $attributes = [
        //'state' => Pending::class,
        // 'state' => 'pending',
    ];
    
    
    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'state',
    ];

    /**  @return array<string, string>   */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'state' => UserState::class,
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
}
