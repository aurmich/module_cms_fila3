<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\SaluteOra\Models\Patient;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'pregnancies';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
             function (Blueprint $table): void {
                $table->id();
                //$this->foreignIdFor($table,Tenant::class);
                $this->foreignIdFor($table,Patient::class);
                $table->date('expected_delivery_date')->nullable();
                $table->integer('weeks_pregnant')->nullable();
                $table->tinyInteger('trimester')->nullable();
                $table->boolean('high_risk')->default(false);
                $table->text('notes')->nullable();
                $table->date('last_checkup_date')->nullable();
                $table->date('next_checkup_date')->nullable();
                $table->string('healthcare_provider')->nullable();
                $table->string('healthcare_facility')->nullable();
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
