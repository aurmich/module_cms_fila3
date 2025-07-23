<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Modules\SaluteOra\Models\Doctor;
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
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('specialization')->nullable();
            $table->json('availability')->nullable();
            
        });
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {

                // La colonna type esiste già nella tabella users
                // Non è necessario aggiungerla di nuovo

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

                if (! $this->hasColumn( 'certification')) {
                    $table->string('certification')->nullable()->after('city');
                }

                if (! $this->hasColumn( 'status')) {
                    $table->string('status')->nullable()->after('registration_number');
                }
                
                foreach(Doctor::getAttachments() as $attachment){
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
