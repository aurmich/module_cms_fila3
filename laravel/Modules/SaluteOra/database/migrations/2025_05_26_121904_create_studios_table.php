<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
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
                $table->string('name');
                $table->string('phone', 30)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('website')->nullable();
                $table->string('registration_number', 50)->nullable();
                $table->string('vat_number', 30)->nullable();
                $table->text('description')->nullable();
                $table->json('opening_hours')->nullable();
                $table->json('services')->nullable();
                $table->boolean('active')->default(true);

                // Indici per performance
                $table->index('active');
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if(!$this->hasColumn('slug')) {
                    $table->string('slug')->nullable();
                }
                if(!$this->hasColumn('model_type')) {
                    $table->string('model_type')->nullable()->index();
                    
                }
                if(!$this->hasColumn('model_id')) {
                    $table->string('model_id',36)->nullable()->index();
                    
                }
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};