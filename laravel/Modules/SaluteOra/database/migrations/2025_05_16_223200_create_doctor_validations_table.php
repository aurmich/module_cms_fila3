<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la creazione della tabella doctor_validations.
 *
 * Questa tabella gestisce le validazioni dei dottori.
 *
 * @see docs/standards/migrations.md
 */
return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     */
    protected string $table = 'doctor_validations';

    /**
     * Connessione al database.
     * (Attenzione: non ridefinire il tipo!)
     */
    protected $connection = 'mysql';

    /**
     * Stati di validazione possibili.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Skip if table already exists
        if (Schema::connection($this->connection)->hasTable($this->table)) {
            return;
        }
        
        // Use transaction to ensure data integrity
        DB::connection($this->connection)->beginTransaction();
        
        try {
            Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
                $table->id();
                
                // Doctor reference
                $table->foreignId('doctor_id')
                    ->constrained('doctors')
                    ->onDelete('cascade')
                    ->comment('Riferimento al dottore da validare');
                    
                // Validation status
                $table->enum('validation_status', [
                    self::STATUS_PENDING,
                    self::STATUS_APPROVED,
                    self::STATUS_REJECTED,
                ])
                ->default(self::STATUS_PENDING)
                ->comment('Stato della validazione');
                
                $table->dateTime('validation_date')
                    ->nullable()
                    ->comment('Data di validazione');
                
                // Validator reference (can be null if not validated yet)
                $table->foreignId('validator_id')
                    ->nullable()
                    ->constrained('doctors')
                    ->onDelete('set null')
                    ->comment('Riferimento al dottore validatore');
                    
                $table->text('validation_notes')
                    ->nullable()
                    ->comment('Note aggiuntive sulla validazione');
                    
                $table->string('document_path')
                    ->nullable()
                    ->comment('Percorso del documento di validazione');
                
                // Standard timestamps
                $table->timestamps();
                $table->softDeletes();
            });
            
            // Add index for better performance on status field
            Schema::connection($this->connection)->table($this->table, function (Blueprint $table) {
                $table->index('validation_status');
            });
            
            DB::connection($this->connection)->commit();
            
        } catch (\Exception $e) {
            DB::connection($this->connection)->rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::connection($this->connection)->hasTable($this->table)) {
            Schema::connection($this->connection)->dropIfExists($this->connection . '.doctor_validation_doctor_id_foreign');
            Schema::connection($this->connection)->dropIfExists($this->connection . '.doctor_validation_validator_id_foreign');
            Schema::connection($this->connection)->dropIfExists($this->table);
        }
    }
};
