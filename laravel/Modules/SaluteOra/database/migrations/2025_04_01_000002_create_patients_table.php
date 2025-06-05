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
    protected string $table = 'patients';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Tenant::class)->constrained()
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->string('name');
                $table->string('last_name');
                $table->string('fiscal_code')->nullable()->unique();
                $table->date('birth_date')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('province')->nullable();
                $table->string('country')->nullable();
                $table->boolean('is_pregnant')->default(false);
                $table->string('isee_code')->nullable();
                $table->decimal('isee_value', 10, 2)->nullable();
                $table->date('isee_expiry_date')->nullable();
                $table->text('notes')->nullable();

                // Controllo se la tabella 'users' esiste prima di aggiungere la chiave esterna
                if (Schema::hasTable('users')) {
                    $table->foreign('tenant_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                }
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {

                // Aggiungi il campo type se non esiste
            if (! $this->hasColumn( 'type')) {
                $table->string('type')->nullable()->after('id');
            }

            // Aggiungi i campi specifici per i dottori
            if (! $this->hasColumn( 'certifications')) {
                $table->json('certifications')->nullable()->after('email');
            }

            if (! $this->hasColumn( 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (! $this->hasColumn( 'address')) {
                $table->string('address')->nullable()->after('phone');
            }

            if (! $this->hasColumn( 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (! $this->hasColumn( 'registration_number')) {
                $table->string('registration_number')->nullable()->after('city');
            }

            if (! $this->hasColumn( 'status')) {
                $table->string('status')->nullable()->after('registration_number');
            }
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};
