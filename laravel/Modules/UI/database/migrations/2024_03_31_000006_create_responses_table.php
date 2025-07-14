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
                $table->string('user_id',36)->index()->nullable();
                $table->string('status')->nullable();
                $table->text('notes')->nullable();
                $table->integer('extension_item_id')->index()->nullable();
                $table->integer('grades')->index()->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if(!$this->hasColumn('form_id')){
                    $table->integer('form_id')->index()->nullable();
                }
                if(!$this->hasColumn('user_id')){
                    $table->string('user_id',36)->index()->nullable();
                }
                if(!$this->hasColumn('status')){
                    $table->string('status')->nullable();
                }
                if(!$this->hasColumn('notes')){
                    $table->text('notes')->nullable();
                }
                if(!$this->hasColumn('extension_item_id')){
                    $table->integer('extension_item_id')->index()->nullable();
                }
                if(!$this->hasColumn('grades')){
                    $table->integer('grades')->index()->nullable();
                }
                
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }


};
