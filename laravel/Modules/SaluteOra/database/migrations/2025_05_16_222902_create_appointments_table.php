<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
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
                $table->foreignIdFor(Patient::class, 'patient_id')
                    ->nullable()
                    ->constrained((new Patient())->getTable())
                    ->nullOnDelete();
                    
                $table->foreignIdFor(Doctor::class, 'doctor_id')
                    ->nullable()
                    ->constrained((new Doctor())->getTable())
                    ->nullOnDelete();
                    
                $table->foreignIdFor(Studio::class, 'studio_id')
                    ->nullable()
                    ->constrained((new Studio())->getTable())
                    ->nullOnDelete();
                    
                $table->string('title')->nullable();
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->string('type')->default('consultation');
                $table->string('state')->default('pending');
                $table->boolean('emergency')->default(false);
                $table->text('notes')->nullable();
                
                // NON aggiungere timestamps qui - vengono gestiti in tableUpdate
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
                
                // Indici per migliorare le prestazioni delle query sul calendario
                if (!$this->hasIndex('appointments_starts_at_index') && $this->hasColumn('starts_at')) {
                    $table->index('starts_at', 'appointments_starts_at_index');
                }

                if (!$this->hasIndex('appointments_ends_at_index') && $this->hasColumn('ends_at')) {
                    $table->index('ends_at', 'appointments_ends_at_index');
                }

                if (!$this->hasIndex('appointments_type_index') && $this->hasColumn('type')) {
                    $table->index('type', 'appointments_type_index');
                }

                if (!$this->hasIndex('appointments_state_index') && $this->hasColumn('state')) {
                    $table->index('state', 'appointments_state_index');
                }

                

                if (!$this->hasIndex('appointments_studio_starts_at_index') && $this->hasColumn('studio_id') && $this->hasColumn('starts_at')) {
                    $table->index(['studio_id', 'starts_at'], 'appointments_studio_starts_at_index');
                }

                if (!$this->hasIndex('appointments_doctor_starts_at_index') && $this->hasColumn('doctor_id') && $this->hasColumn('starts_at')) {
                    $table->index(['doctor_id', 'starts_at'], 'appointments_doctor_starts_at_index');
                }

                if (!$this->hasIndex('appointments_patient_starts_at_index') && $this->hasColumn('patient_id') && $this->hasColumn('starts_at')) {
                    $table->index(['patient_id', 'starts_at'], 'appointments_patient_starts_at_index');
                }

                if(!$this->hasColumn('starts_at')){
                    $table->dateTime('starts_at')->nullable();
                }
                if(!$this->hasColumn('ends_at')){
                    $table->dateTime('ends_at')->nullable();
                }

                if(!$this->hasColumn('invoice')){
                    $table->string('invoice')->nullable()->comment('File fattura');
                }
            }
        );
    }
};
