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
                $table->string('user_id',36)->index()->nullable();
                $table->integer('category_id')->index()->nullable();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('slug')->nullable()->index();
                $table->integer('ordering')->default(0)->index();
                $table->boolean('is_active')->default(true);
                $table->longText('details')->nullable();
                $table->longText('options')->nullable();
                $table->dateTimeTz('start_date')->nullable();
                $table->dateTimeTz('end_date')->nullable();
                $table->text('extensions')->nullable();
            }
        );
        
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if(!$this->hasColumn('user_id')){
                    $table->string('user_id',36)->index()->nullable();
                }
                if(!$this->hasColumn('category_id')){
                    $table->integer('category_id')->index()->nullable();
                }
                if(!$this->hasColumn('name')){
                $table->string('name');
                }
                if(!$this->hasColumn('description')){
                    $table->text('description')->nullable();
                }
                if(!$this->hasColumn('slug')){
                    $table->string('slug')->nullable()->index();
                }
                if(!$this->hasColumn('ordering')){
                    $table->integer('ordering')->default(0)->index();
                }
                if(!$this->hasColumn('is_active')){
                    $table->boolean('is_active')->default(true);
                }
                if(!$this->hasColumn('details')){
                    $table->longText('details')->nullable();
                }
                if(!$this->hasColumn('options')){
                    $table->longText('options')->nullable();
                }
                if(!$this->hasColumn('start_date')){
                    $table->dateTimeTz('start_date')->nullable();
                }
                if(!$this->hasColumn('end_date')){
                    $table->dateTimeTz('end_date')->nullable();
                }
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }


};
