<?php

use Modules\User\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
       // -- CREATE --
       $this->tableCreate(
        function (Blueprint $table): void {
            $table->id();
            if ($this->hasTable('users')) {
                $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onDelete('cascade');
            }
            if (!$this->hasTable('users')) {
                $table->string('user_id',36)->nullable();
            }
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();

        }
        );
    // -- UPDATE --
    $this->tableUpdate(
        function (Blueprint $table): void {
            $this->updateTimestamps($table,true);
        }
    );
    }


};