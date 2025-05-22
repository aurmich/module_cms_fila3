<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Modules\SaluteOra\Models\Dentist;
use Modules\SaluteOra\Models\Patient;
use Illuminate\Support\Facades\Schema;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
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
            $this->foreignIdFor($table,Tenant::class);
            $this->foreignIdFor($table,Patient::class);
            $this->foreignIdFor($table,Dentist::class);
            $this->foreignIdFor($table,Appointment::class);
            $table->string('current_step')->default('patient_info');
            $table->string('status')->default('draft');
            $table->json('step_data')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('last_interaction_at')->nullable();
            $table->json('meta')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('session_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('session_id');
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'created_at']);
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
