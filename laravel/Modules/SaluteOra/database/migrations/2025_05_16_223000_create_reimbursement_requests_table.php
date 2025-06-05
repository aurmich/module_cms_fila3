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
        if (!Schema::connection('mysql')->hasTable('reimbursement_requests')) {
            Schema::connection('mysql')->create('reimbursement_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
                $table->decimal('amount', 8, 2);
                $table->dateTime('request_date');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('reason')->nullable();
                $table->string('document_path')->nullable();
                $table->text('response_notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('reimbursement_requests');
    }
};
