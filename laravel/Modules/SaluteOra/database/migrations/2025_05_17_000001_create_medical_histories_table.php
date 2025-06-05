<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->json('attachments')->nullable();
            $this->addTimestamps($table);
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        $this->tableDrop();
    }
};
