<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Illuminate\Support\Str;

class DoctorRegistrationWorkflow extends BaseModel
{
    use SoftDeletes, BelongsToTenant;
    
    /**
     * Connessione al database da utilizzare.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Gli stati possibili del workflow.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_MODERATION = 'pending_moderation';
    public const STATUS_MODERATION_APPROVED = 'moderation_approved';
    public const STATUS_MODERATION_REJECTED = 'moderation_rejected';
    public const STATUS_COMPLETED = 'completed';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'doctor_id',
        'current_step',
        'status',
        'step_data',
        'started_at',
        'completed_at',
        'last_interaction_at',
        'moderation_token',
        'moderation_notes',
        'moderated_at',
        'moderated_by',
        'created_by',
        'session_id',
    ];

    /**
     * Gli attributi che dovrebbero essere cast a tipi nativi.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'step_data' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'last_interaction_at' => 'datetime',
            'moderated_at' => 'datetime',
        ];
    }

    /**
     * Relazione con il medico.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relazione con il moderatore.
     */
    public function moderator(): BelongsTo
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'moderated_by');
    }

    /**
     * Controlla se questo workflow è completato.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED && $this->completed_at !== null;
    }

    /**
     * Controlla se questo workflow è in attesa di moderazione.
     */
    public function isPendingModeration(): bool
    {
        return $this->status === self::STATUS_PENDING_MODERATION;
    }

    /**
     * Controlla se questo workflow è stato approvato dalla moderazione.
     */
    public function isModerationApproved(): bool
    {
        return $this->status === self::STATUS_MODERATION_APPROVED;
    }

    /**
     * Controlla se questo workflow è stato rifiutato dalla moderazione.
     */
    public function isModerationRejected(): bool
    {
        return $this->status === self::STATUS_MODERATION_REJECTED;
    }

    /**
     * Genera un nuovo token di moderazione.
     */
    public function generateModerationToken(): string
    {
        $this->moderation_token = Str::random(64);
        $this->save();
        return $this->moderation_token;
    }

    /**
     * Ottiene l'elenco dei passi del workflow.
     *
     * @return array<string, string>
     */
    public static function getSteps(): array
    {
        return [
            'personal_info_step' => 'Informazioni Personali',
            'moderation_step' => 'Verifica Dati',
            'contacts_step' => 'Contatti',
            'professional_step' => 'Dati Professionali',
            'availability_step' => 'Disponibilità',
        ];
    }

    /**
     * Ottiene l'indice numerico del passo corrente.
     */
    public function getCurrentStepIndex(): int
    {
        $steps = array_keys(self::getSteps());
        return array_search($this->current_step, $steps) !== false
            ? array_search($this->current_step, $steps)
            : 0;
    }

    /**
     * Verifica se un determinato passo è completato.
     */
    public function isStepCompleted(string $step): bool
    {
        if ($step === 'personal_info_step') {
            return $this->status !== self::STATUS_DRAFT;
        }

        if ($step === 'moderation_step') {
            return $this->isModerationApproved();
        }

        // Gli altri step richiedono che la moderazione sia approvata
        if (!$this->isModerationApproved()) {
            return false;
        }

        $stepIndex = array_search($step, array_keys(self::getSteps()));
        $currentIndex = $this->getCurrentStepIndex();

        return $stepIndex !== false && $currentIndex > $stepIndex;
    }

    /**
     * Verifica se un determinato passo è accessibile.
     */
    public function isStepAccessible(string $step): bool
    {
        if ($step === 'personal_info_step') {
            return true;
        }

        if ($step === 'moderation_step') {
            return $this->status === self::STATUS_PENDING_MODERATION;
        }

        // Gli altri step richiedono che la moderazione sia approvata
        if (!$this->isModerationApproved()) {
            return false;
        }

        $stepIndex = array_search($step, array_keys(self::getSteps()));
        $currentIndex = $this->getCurrentStepIndex();

        return $stepIndex !== false && $currentIndex >= $stepIndex;
    }
} 