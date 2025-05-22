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
        if (!Schema::connection('mysql')->hasTable('patient_documents')) {
            Schema::connection('mysql')->create('patient_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->string('document_type');
                $table->string('document_path');
                $table->dateTime('upload_date');
                $table->text('description')->nullable();
                $table->unsignedBigInteger('uploaded_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('patient_documents');
    }
};
