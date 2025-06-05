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
        if (!Schema::connection('mysql')->hasTable('medical_histories')) {
            Schema::connection('mysql')->create('medical_histories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->string('condition');
                $table->date('diagnosis_date')->nullable();
                $table->text('treatment')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('medical_histories');
    }
};
