<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    /**
     * Tabella pivot per la relazione many-to-many tra Doctor e Studio.
     * Implementa il pattern della tabella pivot con ID autoincrement.
     *
     * @return void
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            // foreignIdFor genera automaticamente la colonna con il nome corretto (doctor_id, studio_id)
            // e imposta la relazione a livello di database
            $table->foreignIdFor(Doctor::class)->comment('ID del dottore');
            $table->foreignIdFor(Studio::class)->comment('ID dello studio');
            $table->json('schedule')->nullable()->comment('Orari del dottore in questo studio');
            $table->boolean('is_primary')->default(false)->comment('Indica se è lo studio principale');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Indice unico per garantire che ogni combinazione doctor-studio sia unica
            if ($this->hasColumn('doctor_id') && $this->hasColumn('studio_id')) {
                $table->unique(['doctor_id', 'studio_id']);
            }
            // Aggiunta dei timestamp e soft delete secondo la filosofia Xot
            $this->updateTimestamps($table, true);
        });
    }


};
