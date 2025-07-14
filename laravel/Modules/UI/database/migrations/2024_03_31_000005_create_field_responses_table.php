<?php

declare(strict_types=1);

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
                $table->integer('form_id')->index()->nullable();
                $table->integer('field_id')->index()->nullable();
                $table->integer('response_id')->index()->nullable();
                $table->longText('response')->nullable();
                $table->integer('grade')->index()->nullable();
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
