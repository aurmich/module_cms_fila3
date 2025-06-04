<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\User;
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
            $table->string('type')->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Studio::class);
            $table->json('schedule')->nullable()->comment('Orari del dottore in questo studio');
            $table->boolean('is_primary')->default(false)->comment('Indica se è lo studio principale');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunta dei timestamp e soft delete secondo la filosofia Xot
            $this->updateTimestamps($table, true);
        });
    }


};
