<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Appointment::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiungi campi se non esistono già
                if (!$this->hasColumn('studio_id')) {
                    $table->foreignId('studio_id')->nullable()->constrained('studios')->onDelete('cascade');
                }

                if (!$this->hasColumn('title')) {
                    $table->string('title')->nullable();
                }

                if (!$this->hasColumn('start_time')) {
                    $table->dateTime('start_time')->nullable();
                }

                if (!$this->hasColumn('end_time')) {
                    $table->dateTime('end_time')->nullable();
                }

                if (!$this->hasColumn('type')) {
                    $table->string('type')->default('consultation');
                }

                if (!$this->hasColumn('status')) {
                    $table->string('status')->default('scheduled');
                }

                if (!$this->hasColumn('emergency')) {
                    $table->boolean('emergency')->default(false);
                }

                // Rimuovi colonne vecchie se esistono
                if ($this->hasColumn('appointment_date')) {
                    $table->dropColumn('appointment_date');
                }

                if ($this->hasColumn('appointment_time')) {
                    $table->dropColumn('appointment_time');
                }

                // Indici per migliorare le prestazioni delle query sul calendario
                if (!$this->hasIndex('appointments_start_time_index')) {
                    $table->index('start_time', 'appointments_start_time_index');
                }

                if (!$this->hasIndex('appointments_end_time_index')) {
                    $table->index('end_time', 'appointments_end_time_index');
                }

                if (!$this->hasIndex('appointments_type_index')) {
                    $table->index('type', 'appointments_type_index');
                }

                if (!$this->hasIndex('appointments_status_index')) {
                    $table->index('status', 'appointments_status_index');
                }
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Rimuovi gli indici
                if ($this->hasIndex('appointments_start_time_index')) {
                    $table->dropIndex('appointments_start_time_index');
                }
                
                if ($this->hasIndex('appointments_end_time_index')) {
                    $table->dropIndex('appointments_end_time_index');
                }
                
                if ($this->hasIndex('appointments_type_index')) {
                    $table->dropIndex('appointments_type_index');
                }
                
                if ($this->hasIndex('appointments_status_index')) {
                    $table->dropIndex('appointments_status_index');
                }

                // Rimuovi i nuovi campi
                $table->dropConstrainedForeignId('studio_id');
                $table->dropColumn([
                    'title',
                    'start_time',
                    'end_time',
                    'type',
                    'status',
                    'emergency'
                ]);

                // Aggiungi di nuovo i campi vecchi
                $table->date('appointment_date')->nullable();
                $table->time('appointment_time')->nullable();
            }
        );
    }
};