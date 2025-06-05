<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::connection('mysql')->hasTable('appointments')) {
            Schema::connection('mysql')->table('appointments', function (Blueprint $table) {
                // Aggiungi campi se non esistono già
                if (!Schema::connection('mysql')->hasColumn('appointments', 'studio_id')) {
                    $table->foreignId('studio_id')->nullable()->constrained('studios')->onDelete('cascade');
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'title')) {
                    $table->string('title')->nullable();
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'start_time')) {
                    $table->dateTime('start_time')->nullable();
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'end_time')) {
                    $table->dateTime('end_time')->nullable();
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'type')) {
                    $table->string('type')->default('consultation');
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'status')) {
                    $table->string('status')->default('scheduled');
                }

                if (!Schema::connection('mysql')->hasColumn('appointments', 'emergency')) {
                    $table->boolean('emergency')->default(false);
                }

                // Rimuovi colonne vecchie se esistono
                if (Schema::connection('mysql')->hasColumn('appointments', 'appointment_date')) {
                    $table->dropColumn('appointment_date');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'appointment_time')) {
                    $table->dropColumn('appointment_time');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'reason')) {
                    $table->dropColumn('reason');
                }

                // Aggiungi indici per performance
                $table->index(['start_time', 'end_time']);
                $table->index(['studio_id', 'start_time']);
                $table->index(['doctor_id', 'start_time']);
                $table->index(['patient_id', 'start_time']);
                $table->index(['type', 'status']);
                $table->index('emergency');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('mysql')->hasTable('appointments')) {
            Schema::connection('mysql')->table('appointments', function (Blueprint $table) {
                // Rimuovi indici
                $table->dropIndex(['start_time', 'end_time']);
                $table->dropIndex(['studio_id', 'start_time']);
                $table->dropIndex(['doctor_id', 'start_time']);
                $table->dropIndex(['patient_id', 'start_time']);
                $table->dropIndex(['type', 'status']);
                $table->dropIndex(['emergency']);

                // Rimuovi colonne aggiunte
                if (Schema::connection('mysql')->hasColumn('appointments', 'studio_id')) {
                    $table->dropForeign(['studio_id']);
                    $table->dropColumn('studio_id');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'title')) {
                    $table->dropColumn('title');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'start_time')) {
                    $table->dropColumn('start_time');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'end_time')) {
                    $table->dropColumn('end_time');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'type')) {
                    $table->dropColumn('type');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'status')) {
                    $table->dropColumn('status');
                }

                if (Schema::connection('mysql')->hasColumn('appointments', 'emergency')) {
                    $table->dropColumn('emergency');
                }

                // Ripristina colonne vecchie
                $table->dateTime('appointment_date');
                $table->dateTime('appointment_time');
                $table->text('reason')->nullable();
            });
        }
    }
};
