<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'appointments';
    
    /**
     * Classe del modello associato.
     *
     * @var string|null
     */
    protected ?string $model_class = Appointment::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Patient::class, 'patient_id');
                $table->foreignIdFor(Doctor::class, 'doctor_id');
                $table->foreignIdFor(Studio::class, 'studio_id');
                $table->dateTime('appointment_date');
                $table->string('status')->default('scheduled');
                $table->text('notes')->nullable();
                $table->string('duration')->default('30'); // in minutes
                $table->string('type')->default('consultation');
                $table->decimal('cost', 8, 2)->nullable();
                $table->string('payment_status')->default('pending');
                $table->json('metadata')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};
