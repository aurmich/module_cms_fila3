<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Activity\Models\Activity;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     * 
     * Aggiorna la tabella activity_log per rendere nullable la colonna causer_id.
     * Copia della migrazione originale con correzione per causer_id nullable.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('log_name')->nullable();
                $table->text('description');
                $table->nullableMorphs('subject', 'subject');
                $table->nullableMorphs('causer', 'causer'); // DEVE essere nullable
                $table->json('properties')->nullable();
                $table->index('log_name');
                $table->uuid('batch_uuid')->nullable();
                $table->string('event')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Assicuriamoci che causer_id sia nullable se esiste
                if ($this->hasColumn('causer_id')) {
                    $table->string('causer_id')->nullable()->change();
                }
                $this->updateTimestamps($table, true);
            }
        );
    }
};
