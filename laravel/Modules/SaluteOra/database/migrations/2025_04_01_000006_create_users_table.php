<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Illuminate\Support\Facades\Schema;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'users';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
          // -- CREATE --
          $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('specialization')->nullable();
            $table->json('availability')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {

                // La colonna type esiste già nella tabella users
                // Non è necessario aggiungerla di nuovo

                // Aggiungi i campi specifici per i dottori
                if (! $this->hasColumn('certifications')) {
                    $table->json('certifications')->nullable()->after('email');
                }

                if (! $this->hasColumn('phone')) {
                    $table->string('phone')->nullable()->after('email');
                }

                if (! $this->hasColumn('address')) {
                    $table->string('address')->nullable()->after('phone');
                }

                if (! $this->hasColumn('city')) {
                    $table->string('city')->nullable()->after('address');
                }

                if (! $this->hasColumn('registration_number')) {
                    $table->string('registration_number')->nullable()->after('city');
                }

                if (! $this->hasColumn('status')) {
                    $table->string('status')->nullable()->after('registration_number');
                }

                // Aggiungi campi per la moderazione generica degli utenti
                if (! $this->hasColumn('state')) {
                    $table->string('state')->default('pending')->after('status');
                }

                if (! $this->hasColumn('moderation_data')) {
                    $table->json('moderation_data')->nullable()->after('state');
                }

                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable()->after('moderation_data');
                }
                if (! $this->hasColumn('date_of_birth')) {
                    $table->date('date_of_birth')->nullable()->after('type');
                }
                if (! $this->hasColumn('gender')) {
                    $table->string('gender', 1)->nullable()->after('date_of_birth');
                }
                if ($this->hasColumn('is_otp')) {
                    $table->boolean('is_otp')->default(false)->nullable()->change();
                }
                if ($this->hasColumn('is_active')) {
                    $table->boolean('is_active')->default(true)->nullable()->change();
                }

                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );


    }
};
