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
        if (!Schema::connection('mysql')->hasTable('studios')) {
            Schema::connection('mysql')->create('studios', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('province')->nullable();
                $table->string('region')->nullable();
                $table->string('country')->default('IT');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('website')->nullable();
                $table->string('registration_number')->nullable();
                $table->string('vat_number')->nullable();
                $table->string('tax_code')->nullable();
                $table->text('description')->nullable();
                $table->json('settings')->nullable();
                $table->json('business_hours')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();

                // Indici per performance
                $table->index('active');
                $table->index('city');
                $table->index('region');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('studios');
    }
};
