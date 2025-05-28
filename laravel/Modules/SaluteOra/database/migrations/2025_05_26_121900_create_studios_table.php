<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'studios';

    /**
     * Classe del modello associato.
     *
     * @var string|null
     */
    protected ?string $model_class = Studio::class;

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
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropTableIfExists($this->getTable());
    }
};