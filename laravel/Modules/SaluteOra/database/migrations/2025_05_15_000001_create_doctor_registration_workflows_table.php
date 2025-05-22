<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la creazione della tabella doctor_registration_workflows.
 *
 * Questa tabella tiene traccia del processo di registrazione dei dottori,
 * inclusi lo stato corrente, il passo attuale del workflow e i timestamps rilevanti.
 *
 * Stati possibili del workflow:
 * - draft: Bozza
 * - pending_moderation: In attesa di moderazione
 * - moderation_approved: Approvato dalla moderazione
 * - moderation_rejected: Rifiutato dalla moderazione
 * - completed: Completato
 *
 * @see docs/standards/migrations.md
 * @see docs/standards/single-table-inheritance.md
 */
return new class extends XotBaseMigration
{
    /**
     * Costanti per gli stati del workflow.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_MODERATION = 'pending_moderation';
    public const STATUS_MODERATION_APPROVED = 'moderation_approved';
    public const STATUS_MODERATION_REJECTED = 'moderation_rejected';
    public const STATUS_COMPLETED = 'completed';

    /**
     * Run the migrations.
     */

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doctor_id');
            $table->string('current_step')->nullable()->comment('Passo corrente del workflow di registrazione');
            $table->string('status')->default(self::STATUS_PENDING_MODERATION)->comment('Stato del workflow di registrazione');
            $table->text('moderation_notes')->nullable()->comment('Note di moderazione');
            $table->timestamp('started_at')->nullable()->comment('Data e ora di inizio del workflow');
            $table->timestamp('completed_at')->nullable()->comment('Data e ora di completamento del workflow');
            $table->timestamp('last_interaction_at')->nullable()->comment('Data e ora dell\'ultima interazione');
            $table->string('session_id')->nullable()->comment('ID della sessione');

            // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
            $this->updateTimestamps($table, true);

            // Verifica se la tabella doctors esiste nella stessa connessione
            //if (Schema::connection($this->getConnection())->hasTable('doctors')) {
            if ($this->hasTable('doctors')) {
                $table->foreign('doctor_id')
                    ->references('id')
                    ->on('doctors')
                    ->onDelete('cascade');
            }

            $table->index('doctor_id');
            $table->index('status');
            $table->index('current_step');
            $table->index('session_id');
        });
    }
};
