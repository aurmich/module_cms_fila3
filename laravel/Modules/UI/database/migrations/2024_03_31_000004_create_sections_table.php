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
                $table->string('name');
                $table->integer('ordering')->default('0')->index();
                $table->integer('columns')->default('1')->index();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->tinyInteger('aside')->default('0');
                $table->tinyInteger('compact')->default('0');
                $table->text('options')->nullable();
                $table->tinyInteger('borderless')->default('0');
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, false);
            }
        );
    }


};
