<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Patient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
            static function (Blueprint $table): void {
                $table->id();
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

                if (! $this->hasColumn( 'last_dental_visit')) {
                    $table->date('last_dental_visit')->nullable()->after('registration_number');
                }
                if (! $this->hasColumn( 'dental_problems')) {
                    $table->text('dental_problems')->nullable()->after('registration_number');
                }
                if (! $this->hasColumn('last_dental_visit_period')) {
                    $table->string('last_dental_visit_period')->nullable();
                }


                if (! $this->hasColumn( 'status')) {
                    $table->string('status')->nullable()->after('registration_number');
                }
                if (! $this->hasColumn( 'fiscal_code')) {
                    $table->string('fiscal_code',16)->nullable()->after('registration_number');
                }

                if (! $this->hasColumn( 'age_range')) {
                    $table->string('age_range')->nullable()->after('registration_number');
                }

                if (! $this->hasColumn( 'identity_document')) {
                    $table->string('identity_document')->nullable()->after('type');
                }
                
                foreach(Patient::getAttachments() as $attachment){
                    if (! $this->hasColumn($attachment)) {
                        $table->string($attachment)->nullable()->after('type');
                    }
                }
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};
