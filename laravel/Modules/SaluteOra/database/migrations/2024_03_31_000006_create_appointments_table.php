<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Patient::class);
                $table->foreignIdFor(Doctor::class);
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('type')->nullable();
                $table->string('status')->default('scheduled');
                $table->text('notes')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, false);
                
                // Aggiunta dei campi per il calendario
                if (!$this->hasColumn('studio_id')) {
                    $table->foreignId('studio_id')->nullable()->constrained('studios')->onDelete('cascade');
                }

                if (!$this->hasColumn('title')) {
                    $table->string('title')->nullable();
                }

                if (!$this->hasColumn('start_datetime')) {
                    $table->dateTime('start_datetime')->nullable();
                }

                if (!$this->hasColumn('end_datetime')) {
                    $table->dateTime('end_datetime')->nullable();
                }

                if (!$this->hasColumn('emergency')) {
                    $table->boolean('emergency')->default(false);
                }

                // Indici per migliorare le prestazioni delle query sul calendario
                if (!$this->hasIndex('appointments_start_datetime_index')) {
                    $table->index('start_datetime', 'appointments_start_datetime_index');
                }

                if (!$this->hasIndex('appointments_end_datetime_index')) {
                    $table->index('end_datetime', 'appointments_end_datetime_index');
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

   
};
