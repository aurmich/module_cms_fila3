<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Anamnesis;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    
    //protected string $table = 'anamnesis';
    protected ?string $model_class = Anamnesis::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $this->foreignIdFor($table,Tenant::class);
                $this->foreignIdFor($table,Patient::class);
                $table->json('allergies')->nullable();
                $table->json('chronic_diseases')->nullable();
                $table->json('medications')->nullable();
                $table->json('family_history')->nullable();
                $table->json('lifestyle')->nullable();
                $table->text('notes')->nullable();
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
};
