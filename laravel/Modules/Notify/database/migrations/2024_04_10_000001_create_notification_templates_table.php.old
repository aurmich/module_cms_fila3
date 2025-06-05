<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('subject')->nullable();
            $table->text('body_html')->nullable();
            $table->text('body_text')->nullable();
            $table->json('channels')->default('[]');
            $table->json('variables')->default('[]');
            $table->json('conditions')->nullable();
            $table->json('preview_data')->nullable();
            $table->json('metadata')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->string('tenant_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['code', 'is_active']);
            $table->index(['category', 'tenant_id']);
        });

        Schema::create('notification_template_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('notification_templates')->cascadeOnDelete();
            $table->string('subject')->nullable();
            $table->text('body_html')->nullable();
            $table->text('body_text')->nullable();
            $table->json('channels')->default('[]');
            $table->json('variables')->default('[]');
            $table->json('conditions')->nullable();
            $table->unsignedInteger('version');
            $table->string('created_by');
            $table->text('change_notes')->nullable();
            $table->timestamps();

            $table->unique(['template_id', 'version']);
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('notification_templates');
            $table->morphs('notifiable');
            $table->string('channel');
            $table->string('status');
            $table->text('status_message')->nullable();
            $table->json('data')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->string('tenant_id')->nullable();
            $table->timestamps();

            $table->index(['channel', 'status']);
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('notification_template_versions');
        Schema::dropIfExists('notification_templates');
    }
}; 