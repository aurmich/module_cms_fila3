<?php
declare(strict_types=1);
namespace Modules\SaluteOra\Models;


use Spatie\Permission\Traits\HasRoles;
use Modules\User\Models\BaseUser;
use Spatie\ModelStates\HasStates;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;

use Modules\SaluteOra\Enums\UserTypeEnum;
use Illuminate\Notifications\Notifiable;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\States\User\Rejected;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\States\User\UserState;
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
    use HasRoles;
    use LogsActivity, Notifiable;
    use HasStates;

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
    ];


    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'state',
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
            //'type' => UserTypeEnum::class, // Sintassi corretta per Laravel 12
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

    /**
     * Get the user's type as a UserTypeEnum enum.
     *
     * Gestione robusta dell'attributo type con nullable safety.
     *
     * Importante: Questo override è nel modello User di SaluteOra (modulo specifico),
     * MAI nel modulo User generico che deve restare puro e riutilizzabile.
     *
     * Principio di modularità: ogni modifica specifica rimane nei moduli specifici.
     */
    public function getTypeAttribute($value): ?UserTypeEnum
    {
        // Se già è un enum, lo restituiamo direttamente
        if ($value instanceof UserTypeEnum) {
            return $value;
        }
        if(empty($value)){
            return UserTypeEnum::default();
        }
        // Utilizziamo il metodo tryFrom dell'enum che gestisce internamente
        // i casi null/empty e cattura le eccezioni ValueError
        return UserTypeEnum::tryFrom($value);
    }

    /**
     * Set the user's type using a UserTypeEnum enum.
     */
    public function setTypeAttribute($value): void
    {
        $this->attributes['type'] = $value instanceof UserTypeEnum ? $value->value : $value;
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
    public function scopeAdmins($query)
    {
        return $query->where('type', UserTypeEnum::ADMIN->value);
    }

    /**
     * Scope per query: solo dottori.
     */
    public function scopeDoctors($query)
    {
        return $query->where('type', UserTypeEnum::DOCTOR->value);
    }

    /**
     * Scope per query: solo pazienti.
     */
    public function scopePatients($query)
    {
        return $query->where('type', UserTypeEnum::PATIENT->value);
    }
}
